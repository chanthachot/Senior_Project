package com.example.finaproject.Fragment

import android.Manifest
import android.app.Dialog
import android.content.Context
import android.content.pm.PackageManager
import android.location.Location
import android.location.LocationManager
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.view.WindowManager
import androidx.core.content.ContextCompat
import androidx.fragment.app.DialogFragment
import androidx.navigation.fragment.NavHostFragment.findNavController
import androidx.navigation.fragment.findNavController
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
import kotlinx.android.synthetic.main.fragment_select_map_edit_found_bird_public.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class ViewMapFoundbirdPublic : BottomSheetDialogFragment(), OnMapReadyCallback {

    private val LOCATION_PERMISSION_REQUEST = 1
    lateinit var mapFragment: SupportMapFragment
    lateinit var mMap: GoogleMap
    private lateinit var fusedLocationClient: FusedLocationProviderClient

    val birdClient = BirdAPI.create()
    val BirdsList = ArrayList<BirdsDB>()

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        mapFragment =
            childFragmentManager.findFragmentById(R.id.map) as SupportMapFragment
        mapFragment.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(requireContext())

        cancelBtn.setOnClickListener {
            dismiss()
        }

    }

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

    private fun getLocationUpdates() {

        fusedLocationClient.lastLocation.addOnSuccessListener { location: Location? ->
            if (location != null) {
                val lat = arguments?.getString("lat").toString()
                val lng = arguments?.getString("lng").toString()
                val bird_name = arguments?.getString("birdName").toString()
                val amount = arguments?.getString("amount").toString()

                val path = LatLng(lat!!.toDouble(), lng!!.toDouble())
                val icon: BitmapDescriptor =
                    BitmapDescriptorFactory.fromResource(R.drawable.bird_marker)
                val mapStyleOptions =
                    MapStyleOptions.loadRawResourceStyle(requireContext(), R.raw.style_map)
                mMap.setMapStyle(mapStyleOptions)
                mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(path, 19f))
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
                                info.amount = amount

                                val markerOptions = MarkerOptions()
                                    .position(path)
                                    .title(birds.bird_id).icon(icon)
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
                                requireView().findViewById(android.R.id.content),
                                "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                                Snackbar.LENGTH_LONG
                            ).show()
                        }
                    })

                mMap.setInfoWindowAdapter(GoogleMapInfoWindowAdapterFoundBird(requireContext()))
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


    private fun isLocationEnable(): Boolean {
        var locationManager: LocationManager =
            requireActivity().getSystemService(Context.LOCATION_SERVICE) as LocationManager
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) || locationManager.isProviderEnabled(
            LocationManager.NETWORK_PROVIDER
        )
    }


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)

        setStyle(DialogFragment.STYLE_NORMAL, R.style.SomeStyle)


    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_view_map_foundbird_public, container, false)
    }

}