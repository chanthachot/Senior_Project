package com.example.finaproject.Fragment

import android.Manifest
import android.content.Context
import android.content.pm.PackageManager
import android.location.Location
import android.location.LocationManager
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.example.finaproject.*
import com.google.android.gms.location.FusedLocationProviderClient
import com.google.android.gms.location.LocationServices
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.GoogleMap.OnInfoWindowClickListener
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.*
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_birds.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class ExploreFragment : Fragment(), OnMapReadyCallback {

    private val LOCATION_PERMISSION_REQUEST = 1
    lateinit var mapFragment: SupportMapFragment
    lateinit var mMap: GoogleMap
    private lateinit var fusedLocationClient: FusedLocationProviderClient

    val foundBirdClient = FoundBirdAPI.create()
    var adapter: foundbirdpublic_adapter? = null
    val itemsModalList = ArrayList<FoundBirdDB>()

    val birdClient = BirdAPI.create()
    val BirdsList = ArrayList<BirdsDB>()


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        mapFragment =
            childFragmentManager.findFragmentById(R.id.MapFoundBirdPublic) as SupportMapFragment
        mapFragment?.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(requireContext())

    }

    override fun onMapReady(googleMap: GoogleMap?) {

        mMap = googleMap!!

        mMap.uiSettings.isZoomControlsEnabled = true

        if (isLocationEnable()) {
            getLocationAccess()
        } else {

            Snackbar.make(
                requireActivity().findViewById(android.R.id.content),
                "กรุณาเปิด GPS ก่อน",
                Snackbar.LENGTH_LONG
            ).show()
            requireActivity().onBackPressed()

        }
    }

    private fun getLocationAccess() {
        if (ContextCompat.checkSelfPermission(
                requireContext(),
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
                    requireActivity().findViewById(android.R.id.content),
                    "การเข้าถึงตำแหน่งถูกปฎิเสธ",
                    Snackbar.LENGTH_LONG
                ).show()
                requireActivity().onBackPressed()
            }
        }
    }

    private fun getLocationUpdates() {

        fusedLocationClient.lastLocation.addOnSuccessListener { location: Location? ->
            foundBirdClient.retrieve_found_bird_public()
                .enqueue(object : Callback<List<FoundBirdDB>> {
                    override fun onResponse(
                        call: Call<List<FoundBirdDB>>,
                        response: Response<List<FoundBirdDB>>
                    ) {
                        response.body()?.forEach { it ->
                            itemsModalList.add(
                                FoundBirdDB(
                                    it.first_name,
                                    it.last_name,
                                    it.email,
                                    it.foundbird_id,
                                    it.bird_family_name,
                                    it.bird_name,
                                    it.amount,
                                    it.lat,
                                    it.lng,
                                    it.date,
                                    it.time,
                                    it.timestamp,
                                    it.foundbird_pic_url,
                                    it.mouth,
                                    it.body,
                                    it.tail,
                                    it.wings,
                                    it.legs,
                                    it.other,
                                    it.place,
                                    it.uid,
                                    it.type
                                )
                            )

                            if (location != null) {
                                val latLng = LatLng(it.lat.toDouble(), it.lng.toDouble())
                                val icon: BitmapDescriptor =
                                    BitmapDescriptorFactory.fromResource(R.drawable.bird_marker)
                                val mapStyleOptions =
                                    MapStyleOptions.loadRawResourceStyle(
                                        requireContext(),
                                        R.raw.style_map
                                    )
                                mMap.setMapStyle(mapStyleOptions)
                                mMap.moveCamera(
                                    CameraUpdateFactory.newLatLngZoom(
                                        LatLng(
                                            location.latitude,
                                            location.longitude
                                        ), 18f
                                    )
                                )

                                birdClient.retrieve_birds_from_bird_name(it.bird_name)
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
                                                    MarkerOptions().position(latLng)
                                                        .title(birds.bird_id).icon(
                                                            icon
                                                        )
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
                                                requireActivity().findViewById(android.R.id.content),
                                                "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                                                Snackbar.LENGTH_LONG
                                            ).show()
                                        }
                                    })

                                mMap.setInfoWindowAdapter(GoogleMapInfoWindowAdapter(requireContext()))

                                mMap.setOnInfoWindowClickListener { marker ->
                                    val action = ExploreFragmentDirections.actionExploreFragmentToBirdDetailFragment(marker.title)
                                    findNavController().navigate(action)
                                }
                            } else {
                                Snackbar.make(
                                    requireActivity().findViewById(android.R.id.content),
                                    "ไม่สามารถเข้าถึงตำแหน่งได้ กรุณาลองใหม่อีกครั้ง",
                                    Snackbar.LENGTH_LONG
                                ).show()
                                requireActivity().onBackPressed()
                            }
                        }
                    }
                    override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) =
                        t.printStackTrace()
                })
        }
    }


    private fun isLocationEnable(): Boolean {
        var locationManager: LocationManager =
            requireActivity().getSystemService(Context.LOCATION_SERVICE) as LocationManager
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) || locationManager.isProviderEnabled(
            LocationManager.NETWORK_PROVIDER
        )
    }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_explore, container, false)
    }

}