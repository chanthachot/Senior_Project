package com.example.finaproject.Fragment

import android.Manifest
import android.app.Dialog
import android.content.Context
import android.content.pm.PackageManager
import android.content.res.Resources
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.location.Location
import android.location.LocationManager
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.View.GONE
import android.view.View.VISIBLE
import android.view.ViewGroup
import android.view.WindowManager
import android.widget.FrameLayout
import androidx.core.content.ContextCompat
import androidx.fragment.app.DialogFragment
import com.example.finaproject.R
import com.google.android.gms.location.FusedLocationProviderClient
import com.google.android.gms.location.LocationServices
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.MapStyleOptions
import com.google.android.gms.maps.model.MarkerOptions
import com.google.android.material.bottomsheet.BottomSheetBehavior
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.google.android.material.dialog.MaterialAlertDialogBuilder
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_select_map_edit_found_bird_public.*
import kotlinx.android.synthetic.main.savemap_dialog.view.*

class SelectMapEditFoundBirdPublic : BottomSheetDialogFragment(),
    GoogleMap.OnCameraMoveStartedListener,
    GoogleMap.OnCameraIdleListener, GoogleMap.OnCameraMoveListener, OnMapReadyCallback {


    private val LOCATION_PERMISSION_REQUEST = 1

    private lateinit var fusedLocationClient: FusedLocationProviderClient
    private lateinit var mMap: GoogleMap
    private lateinit var mapFragment: SupportMapFragment


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setStyle(DialogFragment.STYLE_NORMAL, R.style.SomeStyle)

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

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)



        img_marker.visibility = GONE
        mapFragment = childFragmentManager.findFragmentById(R.id.select_map) as SupportMapFragment
        mapFragment?.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(requireContext())

        cancelBtn.setOnClickListener {
            dismiss()
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

        var Lat = arguments?.getString("lat").toString()
        var Lng = arguments?.getString("lng").toString()

        fusedLocationClient.lastLocation.addOnSuccessListener { location: Location? ->
            if (location != null) {
                val latLng = LatLng(Lat.toDouble(), Lng.toDouble())
                val markerOptions = MarkerOptions().position(latLng)
                val mapStyleOptions =
                    MapStyleOptions.loadRawResourceStyle(requireContext(), R.raw.style_map)
                mMap.setMapStyle(mapStyleOptions)
                mMap.addMarker(markerOptions)
                mMap.moveCamera(CameraUpdateFactory.newLatLngZoom(latLng, 19f))
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


    override fun onMapReady(googleMap: GoogleMap?) {
        mMap = googleMap!!
        mMap.uiSettings.isZoomControlsEnabled = true
        mMap!!.setOnCameraMoveStartedListener(this)
        mMap!!.setOnCameraIdleListener(this)
        mMap!!.setOnCameraMoveListener(this)
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


    private fun isLocationEnable(): Boolean {
        var locationManager: LocationManager =
            requireActivity().getSystemService(Context.LOCATION_SERVICE) as LocationManager
        return locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER) || locationManager.isProviderEnabled(
            LocationManager.NETWORK_PROVIDER
        )
    }


    override fun onCameraMoveStarted(p0: Int) {

    }

    override fun onCameraIdle() {
        img_marker.visibility = GONE
        val markerOptions = MarkerOptions().position(mMap.cameraPosition.target)
        mMap.addMarker(markerOptions)

        val position: LatLng = mMap.cameraPosition.target

        nextBtn.setOnClickListener {
            val dialogView =
                LayoutInflater.from(requireContext()).inflate(
                    R.layout.savemap_dialog,
                    null
                )
            val builder =
                MaterialAlertDialogBuilder(requireActivity()).setView(
                    dialogView
                )

            dialogView.edit_text_place.requestFocus()

            val dialog = builder.create()
            dialog.window?.setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_VISIBLE)
            dialog!!.window!!.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
            dialog.show()

            dialogView.btnSave.setOnClickListener {
                if (dialogView.edit_text_place.text.toString()
                        .isEmpty()
                ) {
                    dialogView.edit_text_place.error =
                        "กรุณากรอกชื่อสถานที่"
                    dialogView.edit_text_place.requestFocus()
                    return@setOnClickListener
                }

                val i = requireActivity().intent
                i.putExtra("place", dialogView.edit_text_place.text.toString())
                i.putExtra("lat", position.latitude.toString())
                i.putExtra("lng", position.longitude.toString())
                targetFragment!!.onActivityResult(targetRequestCode, 101, i)
                dialog.dismiss()
                dismiss()


            }

            dialogView.btnCancel.setOnClickListener {
                dialog.dismiss()
            }

        }
    }

    override fun onCameraMove() {
        mMap.clear()
        img_marker.visibility = VISIBLE

    }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(
            R.layout.fragment_select_map_edit_found_bird_public,
            container,
            false
        )
    }


}