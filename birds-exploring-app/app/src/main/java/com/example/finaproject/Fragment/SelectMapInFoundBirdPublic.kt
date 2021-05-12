package com.example.finaproject.Fragment

import android.Manifest
import android.annotation.SuppressLint
import android.app.AlertDialog
import android.content.Context
import android.content.Intent
import android.content.pm.PackageManager
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.location.Location
import android.location.LocationManager
import android.os.Build
import android.os.Bundle
import android.os.Looper

import android.os.Looper.myLooper
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.View.GONE
import android.view.View.VISIBLE
import android.view.ViewGroup
import android.view.WindowManager
import android.widget.Toast
import androidx.core.app.ActivityCompat
import androidx.core.content.ContextCompat
import androidx.fragment.app.Fragment
import androidx.navigation.Navigation
import androidx.navigation.fragment.findNavController
import androidx.navigation.fragment.navArgs
import cn.pedant.SweetAlert.SweetAlertDialog
import com.example.finaproject.LoginActivity
import com.example.finaproject.R
import com.google.android.gms.common.api.ResolvableApiException
import com.google.android.gms.location.*
import com.google.android.gms.maps.CameraUpdateFactory
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.OnMapReadyCallback
import com.google.android.gms.maps.SupportMapFragment
import com.google.android.gms.maps.model.LatLng
import com.google.android.gms.maps.model.MapStyleOptions
import com.google.android.gms.maps.model.MarkerOptions
import com.google.android.gms.tasks.RuntimeExecutionException
import com.google.android.gms.tasks.Task
import com.google.android.material.dialog.MaterialAlertDialogBuilder
import com.google.android.material.snackbar.Snackbar
import com.karumi.dexter.Dexter
import com.karumi.dexter.PermissionToken
import com.karumi.dexter.listener.PermissionDeniedResponse
import com.karumi.dexter.listener.PermissionGrantedResponse
import com.karumi.dexter.listener.PermissionRequest
import com.karumi.dexter.listener.single.PermissionListener
import kotlinx.android.synthetic.main.fragment_select_map_in_found_bird_public.*
import kotlinx.android.synthetic.main.savemap_dialog.view.*

class SelectMapInFoundBirdPublic : Fragment(), GoogleMap.OnCameraMoveStartedListener,
    GoogleMap.OnCameraIdleListener, GoogleMap.OnCameraMoveListener, OnMapReadyCallback {

    private val LOCATION_PERMISSION_REQUEST = 1
    private lateinit var fusedLocationClient: FusedLocationProviderClient
    private lateinit var mMap: GoogleMap
    private lateinit var mapFragment: SupportMapFragment

    val args: SelectMapInFoundBirdPublicArgs by navArgs()


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)


        img_marker.visibility = GONE
        mapFragment = childFragmentManager.findFragmentById(R.id.select_map) as SupportMapFragment
        mapFragment?.getMapAsync(this)

        fusedLocationClient = LocationServices.getFusedLocationProviderClient(requireContext())

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
            if (location != null) {
                val latLng = LatLng(location.latitude, location.longitude)
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
                requireActivity().onBackPressed()
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
                dialog.dismiss()
                val action =
                    SelectMapInFoundBirdPublicDirections.actionSelectMapInFoundBirdPublicToSaveDetailFoundBirdPublic(
                        dialogView.edit_text_place.text.toString(),
                        position.latitude.toString(),
                        position.longitude.toString(),
                        args.birdFamilyName,
                        args.birdName
                    )
                findNavController().navigate(action)

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
        return inflater.inflate(R.layout.fragment_select_map_in_found_bird_public, container, false)
    }


}