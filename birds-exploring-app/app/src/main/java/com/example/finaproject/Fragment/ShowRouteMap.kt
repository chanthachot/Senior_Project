package com.example.finaproject.Fragment

import android.Manifest
import android.app.Dialog
import android.content.Context
import android.content.pm.PackageManager
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.graphics.Color
import android.location.Location
import android.location.LocationManager
import android.os.AsyncTask
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import androidx.core.content.ContextCompat
import androidx.fragment.app.DialogFragment
import com.example.finaproject.*
import com.google.android.gms.location.FusedLocationProviderClient
import com.google.android.gms.location.LocationServices
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.*
import com.google.android.material.bottomsheet.BottomSheetBehavior
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.google.android.material.snackbar.Snackbar
import com.google.gson.Gson
import com.google.zxing.BinaryBitmap
import com.google.zxing.LuminanceSource
import com.google.zxing.MultiFormatReader
import com.google.zxing.RGBLuminanceSource
import com.google.zxing.common.HybridBinarizer
import kotlinx.android.synthetic.main.fragment_select_map_edit_found_bird_public.*
import okhttp3.OkHttpClient
import okhttp3.Request
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.InputStream


class ShowRouteMap : BottomSheetDialogFragment(), OnMapReadyCallback {

    private val LOCATION_PERMISSION_REQUEST = 1
    lateinit var mapFragment: SupportMapFragment
    lateinit var mMap: GoogleMap
    private lateinit var fusedLocationClient: FusedLocationProviderClient

    val routeClient = PathAPI.create()
    var adapter: path_adapter? = null
    val itemsModalList = ArrayList<PointDB>()

    val qrcodeList = ArrayList<QRCodeDB>()

    var origin: MarkerOptions? = null
    var desination: MarkerOptions? = null

    var latitude = 0.0
    var longitude = 0.0
    var end_latitude = 0.0
    var end_longitude = 0.0

    var mMarkerPoints = ArrayList<LatLng>()
    private var mOrigin: LatLng? = null
    private var mDestination: LatLng? = null


    override fun onCreateDialog(savedInstanceState: Bundle?): Dialog {
        val dialog = BottomSheetDialog(requireContext(), theme)

        dialog.setOnShowListener {
            val bottomSheetDialog = it as BottomSheetDialog
            val parentLayout =
                bottomSheetDialog.findViewById<View>(com.google.android.material.R.id.design_bottom_sheet)
            parentLayout?.let { it ->
                val behaviour = BottomSheetBehavior.from(it)
                setupFullHeight(it)
                behaviour.state = BottomSheetBehavior.STATE_EXPANDED
            }
        }
        return dialog
    }

    private fun setupFullHeight(bottomSheet: View) {
        val layoutParams = bottomSheet.layoutParams
        layoutParams.height = WindowManager.LayoutParams.MATCH_PARENT
        bottomSheet.layoutParams = layoutParams
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        mapFragment =
            childFragmentManager.findFragmentById(R.id.map_show_route) as SupportMapFragment
        mapFragment?.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(requireContext())

        cancelBtn.setOnClickListener {
            dismiss()
        }
    }

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        setStyle(DialogFragment.STYLE_NORMAL, R.style.SomeStyle)


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
                dismiss()
            }
        }
    }

    private fun getLocationUpdates() {
        fusedLocationClient.lastLocation.addOnSuccessListener { location: Location? ->
            val path_id = arguments?.getString("path_id").toString()
            routeClient.retrieve_qrpath(path_id.toInt())
                .enqueue(object : Callback<List<PointDB>> {
                    override fun onResponse(
                        call: Call<List<PointDB>>,
                        response: Response<List<PointDB>>
                    ) {
                        response.body()?.forEach {
                            itemsModalList.add(
                                PointDB(
                                    it.point_id,
                                    it.point_name,
                                    it.path_name,
                                    it.path_id,
                                    it.point_lat,
                                    it.point_lng
                                )
                            )

                            if (location != null) {
                                val latLng =
                                    LatLng(it.point_lat.toDouble(), it.point_lng.toDouble())
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
                                        latLng,
                                        18f
                                    )
                                )
                                val markerOptions =
                                    MarkerOptions().position(latLng)
                                        .title(it.point_name).icon(icon)
                                val m = mMap.addMarker(markerOptions)

                                routeClient.retrieve_qrcode(it.point_id.toInt())
                                    .enqueue(object : Callback<List<QRCodeDB>> {
                                        override fun onResponse(
                                            call: Call<List<QRCodeDB>>,
                                            response: Response<List<QRCodeDB>>
                                        ) {
                                            response.body()?.forEach { qrcode ->
                                                qrcodeList.add(
                                                    QRCodeDB(
                                                        qrcode.point_id,
                                                        qrcode.point_name,
                                                        qrcode.path_id,
                                                        qrcode.point_lat,
                                                        qrcode.point_lng,
                                                        qrcode.qrcode_id,
                                                        qrcode.qrcode_image,
                                                        qrcode.qrcode_timestamp
                                                    )
                                                )

                                                val info = InfoWindowData()
                                                info.point_name = qrcode.point_name
                                                info.qrcode_image = qrcode.qrcode_image
                                                info.qrcode_timestamp = qrcode.qrcode_timestamp

                                                m.tag = info
                                                m.showInfoWindow()
                                            }

                                        }

                                        override fun onFailure(
                                            call: Call<List<QRCodeDB>>,
                                            t: Throwable
                                        ) {
                                            Snackbar.make(
                                                requireActivity().findViewById(android.R.id.content),
                                                "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                                                Snackbar.LENGTH_LONG
                                            ).show()
                                        }
                                    })


                                mMap.setInfoWindowAdapter(
                                    GoogleMapInfoWindowQRCodeAdapter(
                                        requireContext()
                                    )
                                )

//                                mMap.setOnInfoWindowClickListener { marker ->
//                                    val action =
//                                        ExploreFragmentDirections.actionExploreFragmentToBirdDetailFragment(
//                                            marker.title
//                                        )
//                                    findNavController().navigate(action)
//                                }


                                mMarkerPoints.add(latLng)

                                for (i in 0 until mMarkerPoints.size) {
                                    if (i >= 1 && i <= mMarkerPoints.size) {
                                        mOrigin = mMarkerPoints[i - 1]
                                        mDestination = mMarkerPoints[i]

                                        val URL =
                                            getDirectionURL(mOrigin!!, mDestination!!)
                                        GetDirection(URL).execute()
                                    }
                                }


                            } else {
                                Snackbar.make(
                                    requireActivity().findViewById(android.R.id.content),
                                    "ไม่สามารถเข้าถึงตำแหน่งได้ กรุณาลองใหม่อีกครั้ง",
                                    Snackbar.LENGTH_LONG
                                ).show()
                                dismiss()
                            }

                        }

                    }


                    override fun onFailure(call: Call<List<PointDB>>, t: Throwable) =
                        t.printStackTrace()
                })
        }
    }



    fun getDirectionURL(origin: LatLng, dest: LatLng): String {
        // Origin of route
        val str_origin = "origin=" + origin.latitude + "," + origin.longitude

        // Destination of route
        val str_dest = "destination=" + dest.latitude + "," + dest.longitude

        // Key
        val key = "key=" + getString(R.string.google_maps_key)

        val mode = "mode=driving"

        // Building the parameters to the web service
        val parameters = "$str_origin&$str_dest&$mode&$key"

        // Output format
        val output = "json"

        // Building the url to the web service
        return "https://maps.googleapis.com/maps/api/directions/$output?$parameters"
    }

    private inner class GetDirection(val url: String) :
        AsyncTask<Void, Void, List<List<LatLng>>>() {
        override fun doInBackground(vararg params: Void?): List<List<LatLng>> {
            val client = OkHttpClient()
            val request = Request.Builder().url(url).build()
            val response = client.newCall(request).execute()
            val data = response.body()!!.string()
            Log.d("GoogleMap", " data : $data")
            val result = ArrayList<List<LatLng>>()
            try {
                val respObj = Gson().fromJson(data, GoogleMapDTO::class.java)

                val path = ArrayList<LatLng>()

                for (i in 0 until respObj.routes[0].legs[0].steps.size) {
                    path.addAll(decodePolyline(respObj.routes[0].legs[0].steps[i].polyline.points))
                }
                result.add(path)
            } catch (e: Exception) {
                e.printStackTrace()
            }
            return result
        }

        override fun onPostExecute(result: List<List<LatLng>>) {
            val lineoption = PolylineOptions()
            for (i in result.indices) {
                lineoption.addAll(result[i])
                lineoption.width(10f)
                lineoption.color(Color.RED)
                lineoption.geodesic(true)
            }
            mMap.addPolyline(lineoption)
        }
    }

    public fun decodePolyline(encoded: String): List<LatLng> {

        val poly = ArrayList<LatLng>()
        var index = 0
        val len = encoded.length
        var lat = 0
        var lng = 0

        while (index < len) {
            var b: Int
            var shift = 0
            var result = 0
            do {
                b = encoded[index++].toInt() - 63
                result = result or (b and 0x1f shl shift)
                shift += 5
            } while (b >= 0x20)
            val dlat = if (result and 1 != 0) (result shr 1).inv() else result shr 1
            lat += dlat

            shift = 0
            result = 0
            do {
                b = encoded[index++].toInt() - 63
                result = result or (b and 0x1f shl shift)
                shift += 5
            } while (b >= 0x20)
            val dlng = if (result and 1 != 0) (result shr 1).inv() else result shr 1
            lng += dlng

            val latLng = LatLng((lat.toDouble() / 1E5), (lng.toDouble() / 1E5))
            poly.add(latLng)
        }

        return poly
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
        return inflater.inflate(R.layout.fragment_show_route_map, container, false)
    }

}