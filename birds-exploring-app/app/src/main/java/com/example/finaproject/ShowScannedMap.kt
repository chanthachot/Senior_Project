package com.example.finaproject

import android.Manifest
import android.content.Context
import android.content.pm.PackageManager
import android.location.Location
import android.location.LocationManager
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import androidx.core.content.ContextCompat
import com.example.finaproject.Fragment.InfoWindowData
import com.google.android.gms.location.FusedLocationProviderClient
import com.google.android.gms.location.LocationServices
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.*
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_scan.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class ShowScannedMap : AppCompatActivity(),
    OnMapReadyCallback {

    val scanClient = BirdAPI.create()
    var array_bird_id = ArrayList<String>()
    var array_bird_name = ArrayList<String>()
    val itemsModalList = ArrayList<BirdsDB>()

    val birdClient = BirdAPI.create()
    val BirdsList = ArrayList<BirdsDB>()


    private val LOCATION_PERMISSION_REQUEST = 1
    lateinit var mapFragment: SupportMapFragment
    lateinit var mMap: GoogleMap
    private lateinit var fusedLocationClient: FusedLocationProviderClient

    lateinit var bird_id: String
    var bird_name: String = ""

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_show_scanned_map)

        mapFragment = supportFragmentManager.findFragmentById(R.id.map) as SupportMapFragment
        mapFragment?.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(this)
    }

    override fun onMapReady(googleMap: GoogleMap?) {

        mMap = googleMap!!
        mMap.uiSettings.isZoomControlsEnabled = true

        if (isLocationEnable()) {
            getLocationAccess()
        } else {

            Snackbar.make(
                findViewById(android.R.id.content),
                "กรุณาเปิด GPS ก่อน",
                Snackbar.LENGTH_LONG
            ).show()
            this.onBackPressed()

        }
    }

    private fun getLocationUpdates() {
        fusedLocationClient.lastLocation.addOnSuccessListener { location: Location? ->
            val qrcode = intent.getStringExtra("qrcode")
            var separate = qrcode!!.split("/".toRegex())

            if (location != null) {
                for (i in 0..separate.size - 2) {
                    var i = i
                    if (i % 3 == 0) {
                        bird_id = separate[i + 2]
                        scanClient.retrieve_bird_detail(bird_id)
                            .enqueue(object : Callback<List<BirdsDB>> {
                                override fun onResponse(
                                    call: Call<List<BirdsDB>>,
                                    response: Response<List<BirdsDB>>
                                ) {

                                    itemsModalList.clear();
                                    response.body()?.forEach {
                                        bird_name = it.bird_name
                                    }
                                    val qrcodepath =
                                        LatLng(separate[i].toDouble(), separate[i + 1].toDouble())
                                    val icon: BitmapDescriptor =
                                        BitmapDescriptorFactory.fromResource(R.drawable.bird_marker)

                                    val mapStyleOptions =
                                        MapStyleOptions.loadRawResourceStyle(
                                            applicationContext,
                                            R.raw.style_map
                                        )
                                    mMap.setMapStyle(mapStyleOptions)
                                    mMap.moveCamera(
                                        CameraUpdateFactory.newLatLngZoom(
                                            qrcodepath,
                                            18f
                                        )
                                    )

                                    birdClient.retrieve_birds_from_bird_name(bird_name)
                                        .enqueue(object : Callback<List<BirdsDB>> {
                                            override fun onResponse(
                                                call: Call<List<BirdsDB>>,
                                                response: Response<List<BirdsDB>>
                                            ) {
                                                response.body()?.forEach { birds ->
                                                    BirdsList.add(
                                                        BirdsDB(
                                                            birds.bird_id,
                                                            birds.bird_name,
                                                            birds.bird_commonname,
                                                            birds.bird_sciname,
                                                            birds.bird_description,
                                                            birds.bird_habitat,
                                                            birds.bird_family_name,
                                                            birds.bird_pic_name
                                                        )
                                                    )

                                                    val info = InfoWindowData()
                                                    info.bird_name = birds.bird_name
                                                    info.bird_family_name = birds.bird_family_name
                                                    info.bird_sciname = birds.bird_sciname
                                                    info.bird_pic_name = birds.bird_pic_name

                                                    val markerOptions =
                                                        MarkerOptions().position(qrcodepath)
                                                            .title(bird_name)
                                                            .icon(icon)
                                                    val m = mMap.addMarker(markerOptions)
                                                    m.tag = info
                                                    m.showInfoWindow()
                                                }

                                            }

                                            override fun onFailure(
                                                call: Call<List<BirdsDB>>,
                                                t: Throwable
                                            ) {
                                                Snackbar.make(
                                                    findViewById(android.R.id.content),
                                                    "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                                                    Snackbar.LENGTH_LONG
                                                ).show()
                                            }
                                        })

                                    mMap.setInfoWindowAdapter(GoogleMapInfoWindowAdapter(this@ShowScannedMap))


                                }

                                override fun onFailure(call: Call<List<BirdsDB>>, t: Throwable) {

                                }
                            })
                    }
                }
            } else {
                Snackbar.make(
                    findViewById(android.R.id.content),
                    "ไม่สามารถเข้าถึงตำแหน่งได้ กรุณาลองใหม่อีกครั้ง",
                    Snackbar.LENGTH_LONG
                ).show()
                this.onBackPressed()
            }

        }
    }

    private fun getLocationAccess() {
        if (ContextCompat.checkSelfPermission(
                this,
                Manifest.permission.ACCESS_FINE_LOCATION
            ) == PackageManager.PERMISSION_GRANTED
        ) {
            mMap.isMyLocationEnabled = true
            getLocationUpdates()
        } else {
            requestPermissions(
                arrayOf(Manifest.permission.ACCESS_FINE_LOCATION),
                LOCATION_PERMISSION_REQUEST
            )
        }
    }

    override fun onRequestPermissionsResult(
        requestCode: Int,
        permissions: Array<String>,
        grantResults: IntArray
    ) {
        if (requestCode == LOCATION_PERMISSION_REQUEST) {
            if (grantResults.contains(PackageManager.PERMISSION_GRANTED)) {
                getLocationAccess()
            } else {
                Snackbar.make(
                    findViewById(android.R.id.content),
                    "การเข้าถึงตำแหน่งถูกปฎิเสธ",
                    Snackbar.LENGTH_LONG
                ).show()
                this.onBackPressed()
            }
        }
    }

    private fun isLocationEnable(): Boolean {
        var locationManager: LocationManager =
            this.getSystemService(Context.LOCATION_SERVICE) as LocationManager
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) || locationManager.isProviderEnabled(
            LocationManager.NETWORK_PROVIDER
        )
    }

}