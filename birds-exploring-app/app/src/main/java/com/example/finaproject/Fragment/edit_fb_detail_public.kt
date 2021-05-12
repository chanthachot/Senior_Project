package com.example.finaproject.Fragment

import android.Manifest
import android.app.*
import android.content.ContentValues
import android.content.Intent
import android.content.pm.PackageManager
import android.content.res.Resources
import android.graphics.Bitmap
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.net.Uri
import android.os.Bundle
import android.provider.MediaStore
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.View.GONE
import android.view.View.VISIBLE
import android.view.ViewGroup
import android.view.WindowManager
import android.widget.LinearLayout
import android.widget.Toast
import androidx.core.content.ContextCompat
import androidx.core.view.isVisible
import androidx.navigation.fragment.findNavController
import cn.pedant.SweetAlert.SweetAlertDialog
import coil.api.load
import com.bumptech.glide.Glide
import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialog
import com.example.finaproject.FoundBirdAPI
import com.example.finaproject.FoundBirdDB
import com.example.finaproject.R
import com.example.finaproject.ViewPictureActivity
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.google.android.material.bottomsheet.BottomSheetBehavior
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.storage.FirebaseStorage
import com.google.firebase.storage.StorageReference
import kotlinx.android.synthetic.main.fragment_edit_fb_detail_public.*
import kotlinx.android.synthetic.main.fragment_edit_fb_detail_public.elegantBtn
import kotlinx.android.synthetic.main.fragment_save_detail_found_bird_public.*
import kotlinx.android.synthetic.main.select_action_image_dialog.view.*
import kotlinx.android.synthetic.main.select_source_image_dialog.view.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException
import java.text.SimpleDateFormat
import java.util.*


class edit_fb_detail_public : BottomSheetDialogFragment() {

    val DIALOG_FRAGMENT = 1
    val SELECT_MAP = 101

    val getDate = Calendar.getInstance()
    val year = getDate.get(Calendar.YEAR)
    val month = getDate.get(Calendar.MONTH)
    val day = getDate.get(Calendar.DAY_OF_MONTH)
    val hours = getDate.get(Calendar.HOUR_OF_DAY)
    val minutes = getDate.get(Calendar.MINUTE)

    val TAKE_PICTURE = 1
    val SELECT_PICTURE = 2
    private val PERMISSION_REQUEST_CODE = 3

    private var Folder: StorageReference? = null

    private lateinit var bitmap: Bitmap

    val foundBirdClient = FoundBirdAPI.create()

    private lateinit var imageUri: Uri

    lateinit var arrayPicUrl: ArrayList<String>
    private val arrayPicUri = ArrayList<Uri>()
    private val arrayPicUriNew = ArrayList<String>()

    private var progressDialog: ProgressDialog? = null

    private lateinit var foundbirdID: String
    private lateinit var Birdname: String
    private lateinit var Birdfamilyname: String
    private lateinit var Lat: String
    private lateinit var Lng: String
    private lateinit var Place: String
    private lateinit var Date: String
    private lateinit var Time: String
    private lateinit var Mouth: String
    private lateinit var Body: String
    private lateinit var Wings: String
    private lateinit var Legs: String
    private lateinit var Tail: String
    private lateinit var Other: String
    private lateinit var amount: String

    private lateinit var place_dialog: String
    private lateinit var lat_dialog: String
    private lateinit var lng_dialog: String


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        foundbirdID = arguments?.getString("foundbirdid").toString()
        arrayPicUrl = arguments?.getStringArrayList("birdpic") as ArrayList<String>
        Birdname = arguments?.getString("birdName").toString()
        Birdfamilyname = arguments?.getString("birdfamilyname").toString()
        Lat = arguments?.getString("lat").toString()
        Lng = arguments?.getString("lng").toString()
        Place = arguments?.getString("place").toString()
        Date = arguments?.getString("date").toString()
        Time = arguments?.getString("time").toString()
        Mouth = arguments?.getString("mouth").toString()
        Body = arguments?.getString("body").toString()
        Wings = arguments?.getString("wings").toString()
        Legs = arguments?.getString("legs").toString()
        Tail = arguments?.getString("tail").toString()
        Other = arguments?.getString("other").toString()
        amount = arguments?.getString("amount").toString()

        val button = elegantBtn as ElegantNumberButton

        birdname.text = Birdname
        birdFamilyName.text = Birdfamilyname
        edt_place.setText(Place)
        edt_date.setText(Date)
        edt_time.setText(Time)
        edt_mouth.setText(Mouth)
        edt_body.setText(Body)
        edt_wings.setText(Wings)
        edt_legs.setText(Legs)
        edt_tail.setText(Tail)
        edt_other.setText(Other)
        button.number = amount

        carouselViewEditFoundbird.setImageClickListener {
            selectActionDialog()
        }

//        showImageEditFoundbird.setOnClickListener {
//            selectActionDialog()
//        }

        cancelBtn.setOnClickListener {
            dismiss()
        }

        edt_date.setOnClickListener {
            datePicker()
        }

        edt_time.setOnClickListener {
            timePicker()
        }

        FB_saveBtn.setOnClickListener {
            updateFoundBird()
        }

        edt_place.setOnClickListener {
            var selectMapFoundBird = SelectMapEditFoundBirdPublic()
            val bundle = Bundle()
            bundle.putString("lat", Lat)
            bundle.putString("lng", Lng)
            selectMapFoundBird.arguments = bundle
            selectMapFoundBird.setTargetFragment(this, DIALOG_FRAGMENT);
            selectMapFoundBird.show(
                requireActivity().supportFragmentManager,
                "TAG"
            )
        }

        showCarouselPicture()
    }

    fun showCarouselPicture() {
        val shimmer = Shimmer.ColorHighlightBuilder()
            .setBaseColor(Color.parseColor("#F3F3F3"))
            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
            .setHighlightAlpha(1F)
            .setDropoff(
                50F
            ).build()
        val shimmerDrawable = ShimmerDrawable()
        shimmerDrawable.setShimmer(shimmer)

        carouselViewEditFoundbird.setImageListener { position, imageView ->
            imageView.load(arrayPicUrl[position]) {
                placeholder(shimmerDrawable)
                crossfade(true)
            }
        }
        carouselViewEditFoundbird.pageCount = arrayPicUrl.size
    }

    fun datePicker() {
        val datePicker = DatePickerDialog(
            requireContext(), android.R.style.Theme_Holo_Light_Dialog_MinWidth,
            DatePickerDialog.OnDateSetListener { datePicker, mYear, mMonth, mDay ->

                var Day = mDay
                var Month = mMonth

                var nd = "" + Day

                if (Day < 10) {
                    nd = "0" + Day
                }

                if (Month >= 0) {
                    Month += 1
                }

                edt_date.setText("$nd/$Month/$mYear")

            },
            year,
            month,
            day
        )
        datePicker.window!!.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
        datePicker.show()
    }

    fun timePicker() {
        val timePickerDialog = TimePickerDialog(
            requireContext(),
            android.R.style.Theme_Holo_Light_Dialog_MinWidth,
            TimePickerDialog.OnTimeSetListener { timePicker, houseOfDay, minute ->

                val timeFromPicker = "" + houseOfDay + ":" + minute;

                val timeFormat = SimpleDateFormat("HH:mm")
                val parse = timeFormat.parse(timeFromPicker)
                edt_time.setText(timeFormat.format(parse))
            }, hours, minutes, true

        )
        timePickerDialog.window!!.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
        timePickerDialog.show()
    }

    fun selectActionDialog() {
        val SelectActionImageDialog = RoundedBottomSheetDialog(requireContext())
        val view = layoutInflater.inflate(R.layout.select_action_image_dialog, null)
        SelectActionImageDialog.setContentView(view)

        SelectActionImageDialog.show()

        view.add_image.setOnClickListener {
            checkPermission()
            SelectActionImageDialog.dismiss()
        }

        view.clear_image.setOnClickListener {
            arrayPicUri.clear()
            SelectActionImageDialog.dismiss()
            showCarouselPicture()
        }
    }

    fun selectPictureDialog() {
        val SelectSourceImageDialog = RoundedBottomSheetDialog(requireContext())
        val view = layoutInflater.inflate(R.layout.select_source_image_dialog, null)
        SelectSourceImageDialog.setContentView(view)

        SelectSourceImageDialog.show()

        view.select_image.setOnClickListener {
            dispatchGalleryIntent()
            SelectSourceImageDialog.dismiss()
        }

        view.take_picture.setOnClickListener {
            dispatchCameraIntent()
            SelectSourceImageDialog.dismiss()
        }
    }

    fun dispatchCameraIntent() {
        val values = ContentValues()
        values.put(MediaStore.Images.Media.TITLE, "New Picture")
        values.put(MediaStore.Images.Media.DESCRIPTION, "From Your Camera")
        imageUri = requireActivity().contentResolver.insert(
            MediaStore.Images.Media.EXTERNAL_CONTENT_URI,
            values
        )!!
        val intent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
        intent.putExtra(MediaStore.EXTRA_OUTPUT, imageUri)
        startActivityForResult(intent, TAKE_PICTURE)
    }

    fun dispatchGalleryIntent() {
        val intent = Intent()
        intent.type = "image/*"
        intent.action = Intent.ACTION_PICK
        intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true)
        startActivityForResult(Intent.createChooser(intent, "Select Picture"), SELECT_PICTURE)
    }

    fun checkPermission() {
        if (ContextCompat.checkSelfPermission(
                requireContext(),
                Manifest.permission.CAMERA
            ) + ContextCompat
                .checkSelfPermission(
                    requireContext(),
                    Manifest.permission.READ_EXTERNAL_STORAGE
                ) + ContextCompat
                .checkSelfPermission(
                    requireContext(),
                    Manifest.permission.WRITE_EXTERNAL_STORAGE
                ) == PackageManager.PERMISSION_GRANTED
        ) {
            selectPictureDialog()
        } else {
            requestPermissions(
                arrayOf(
                    Manifest.permission.CAMERA,
                    Manifest.permission.WRITE_EXTERNAL_STORAGE,
                    Manifest.permission.READ_EXTERNAL_STORAGE
                ),
                PERMISSION_REQUEST_CODE
            )
        }
    }

    override fun onRequestPermissionsResult(
        requestCode: Int,
        permissions: Array<out String>,
        grantResults: IntArray
    ) {
        if (requestCode == PERMISSION_REQUEST_CODE) {
            if (grantResults.isNotEmpty() && grantResults[0] + grantResults[1] + grantResults[2] == PackageManager.PERMISSION_GRANTED) {
                selectPictureDialog()
            } else {
                Snackbar.make(
                    requireActivity().findViewById(android.R.id.content),
                    "การอนุญาตถูกปฎิเสธ กรุณาลองใหม่อีกครั้ง",
                    Snackbar.LENGTH_LONG
                ).show()
            }
        }
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == TAKE_PICTURE && resultCode == Activity.RESULT_OK && data != null) {
            arrayPicUri.add(imageUri)

            val shimmer = Shimmer.ColorHighlightBuilder()
                .setBaseColor(Color.parseColor("#F3F3F3"))
                .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                .setHighlightAlpha(1F)
                .setDropoff(
                    50F
                ).build()
            val shimmerDrawable = ShimmerDrawable()
            shimmerDrawable.setShimmer(shimmer)

            carouselViewEditFoundbird.setImageListener { position, imageView ->
                imageView.load(arrayPicUri[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewEditFoundbird.pageCount = arrayPicUri.size
        } else {
            super.onActivityResult(requestCode, resultCode, data)
        }

        if (requestCode == SELECT_PICTURE && resultCode == Activity.RESULT_OK && data != null && data.data != null) {
            if (data.clipData != null) {
                for (i in 0 until data.clipData!!.itemCount) {
                    imageUri = data.clipData!!.getItemAt(i).uri
                    arrayPicUri.add(imageUri)
                }
            } else {
                imageUri = data.data!!
                arrayPicUri.add(imageUri)
            }

            val shimmer = Shimmer.ColorHighlightBuilder()
                .setBaseColor(Color.parseColor("#F3F3F3"))
                .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                .setHighlightAlpha(1F)
                .setDropoff(
                    50F
                ).build()
            val shimmerDrawable = ShimmerDrawable()
            shimmerDrawable.setShimmer(shimmer)

            carouselViewEditFoundbird.setImageListener { position, imageView ->
                imageView.load(arrayPicUri[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewEditFoundbird.pageCount = arrayPicUri.size

        } else {
            super.onActivityResult(requestCode, resultCode, data)
        }

        if (resultCode == SELECT_MAP) {
            place_dialog = data!!.getStringExtra("place").toString()
            lat_dialog = data!!.getStringExtra("lat").toString()
            lng_dialog = data!!.getStringExtra("lng").toString()
            if (place_dialog != null && lat_dialog != null && lng_dialog != null) {
                edt_place.setText(place_dialog)
            }
        }
    }

    fun updateFoundBird() {
        if (edt_date.text.toString().isEmpty()) {
            Snackbar.make(
                requireActivity().findViewById(android.R.id.content),
                "กรุณาเลือกวันที่",
                Snackbar.LENGTH_LONG
            ).show()
            return
        } else if (edt_time.text.toString().isEmpty()) {
            Snackbar.make(
                requireActivity().findViewById(android.R.id.content),
                "กรุณาเลือกเวลา",
                Snackbar.LENGTH_LONG
            ).show()
            return
        }

        progressDialog = ProgressDialog(requireContext())
        progressDialog?.show()
        progressDialog?.setContentView(R.layout.loading)
        progressDialog?.setCanceledOnTouchOutside(false)
        progressDialog?.window!!.setBackgroundDrawableResource(android.R.color.transparent)

        if (this::lat_dialog.isInitialized && this::lng_dialog.isInitialized) {
            latLngInitialized()
        } else {
            latLngNotInitialized()
        }
    }

    fun latLngInitialized() {
        if (this::imageUri.isInitialized) {
            latLngAndImageInitialized()
        } else {
            latLngInitializedButImageNotInitialized()
        }
    }

    fun latLngAndImageInitialized() {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        for (i in 0 until arrayPicUri.size) {
            val folder =
                FirebaseStorage.getInstance().reference.child("FoundBird")
                    .child(currentTimestamp + (0..10).random() + arrayPicUri[i].lastPathSegment)

            folder!!.putFile(arrayPicUri[i]).addOnSuccessListener {
                folder.downloadUrl.addOnSuccessListener { uri ->
                    arrayPicUriNew.add(uri.toString())

                    if (arrayPicUri.size == arrayPicUriNew.size) {
                        foundBirdClient.updateFoundBird(
                            foundbirdID.toInt(),
                            birdFamilyName.text.toString(),
                            birdname.text.toString(),
                            button.number,
                            lat_dialog,
                            lng_dialog,
                            edt_date.text.toString(),
                            edt_time.text.toString(),
                            edt_mouth.text.toString(),
                            edt_body.text.toString(),
                            edt_tail.text.toString(),
                            edt_wings.text.toString(),
                            edt_legs.text.toString(),
                            edt_other.text.toString(),
                            edt_place.text.toString()
                        ).enqueue(object : Callback<FoundBirdDB> {
                            override fun onResponse(
                                call: Call<FoundBirdDB>,
                                response: Response<FoundBirdDB>
                            ) {
                                for (index in 0 until arrayPicUriNew.size) {
                                    foundBirdClient.insertFoundBirdPic(
                                        arrayPicUriNew[index],
                                        foundbirdID
                                    ).enqueue(object : Callback<FoundBirdDB> {
                                        override fun onResponse(
                                            call: Call<FoundBirdDB>,
                                            response: Response<FoundBirdDB>
                                        ) {
                                            finishUpdate()
                                        }

                                        override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                            failUpdate()
                                        }
                                    })
                                }
                            }

                            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                failUpdate()
                            }

                        })

                    }
                }
            }
        }
    }

    fun latLngInitializedButImageNotInitialized() {
        val button = elegantBtn as ElegantNumberButton

        foundBirdClient.updateFoundBird(
            foundbirdID.toInt(),
            birdFamilyName.text.toString(),
            birdname.text.toString(),
            button.number,
            lat_dialog,
            lng_dialog,
            edt_date.text.toString(),
            edt_time.text.toString(),
            edt_mouth.text.toString(),
            edt_body.text.toString(),
            edt_tail.text.toString(),
            edt_wings.text.toString(),
            edt_legs.text.toString(),
            edt_other.text.toString(),
            edt_place.text.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                finishUpdate()
            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failUpdate()
            }

        })
    }

    fun latLngNotInitialized() {
        if (this::imageUri.isInitialized) {
            latLngNotInitializedButImageInitialized()
        } else {
            latLngAndImageNotInitialized()
        }
    }

    fun latLngNotInitializedButImageInitialized() {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        for (i in 0 until arrayPicUri.size) {
            val folder =
                FirebaseStorage.getInstance().reference.child("FoundBird")
                    .child(currentTimestamp + (0..10).random() + arrayPicUri[i].lastPathSegment)

            folder!!.putFile(arrayPicUri[i]).addOnSuccessListener {
                folder.downloadUrl.addOnSuccessListener { uri ->
                    arrayPicUriNew.add(uri.toString())

                    if (arrayPicUri.size == arrayPicUriNew.size) {
                        foundBirdClient.updateFoundBird(
                            foundbirdID.toInt(),
                            birdFamilyName.text.toString(),
                            birdname.text.toString(),
                            button.number,
                            Lat,
                            Lng,
                            edt_date.text.toString(),
                            edt_time.text.toString(),
                            edt_mouth.text.toString(),
                            edt_body.text.toString(),
                            edt_tail.text.toString(),
                            edt_wings.text.toString(),
                            edt_legs.text.toString(),
                            edt_other.text.toString(),
                            edt_place.text.toString()
                        ).enqueue(object : Callback<FoundBirdDB> {
                            override fun onResponse(
                                call: Call<FoundBirdDB>,
                                response: Response<FoundBirdDB>
                            ) {
                                for (index in 0 until arrayPicUriNew.size) {
                                    foundBirdClient.insertFoundBirdPic(
                                        arrayPicUriNew[index],
                                        foundbirdID
                                    ).enqueue(object : Callback<FoundBirdDB> {
                                        override fun onResponse(
                                            call: Call<FoundBirdDB>,
                                            response: Response<FoundBirdDB>
                                        ) {
                                            finishUpdate()
                                        }

                                        override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                            failUpdate()
                                        }
                                    })
                                }
                            }

                            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                failUpdate()
                            }
                        })
                    }
                }
            }
        }
    }

    fun latLngAndImageNotInitialized() {
        val button = elegantBtn as ElegantNumberButton

        foundBirdClient.updateFoundBird(
            foundbirdID.toInt(),
            birdFamilyName.text.toString(),
            birdname.text.toString(),
            button.number,
            Lat,
            Lng,
            edt_date.text.toString(),
            edt_time.text.toString(),
            edt_mouth.text.toString(),
            edt_body.text.toString(),
            edt_tail.text.toString(),
            edt_wings.text.toString(),
            edt_legs.text.toString(),
            edt_other.text.toString(),
            edt_place.text.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                finishUpdate()
            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failUpdate()
            }
        })
    }

    fun finishUpdate() {
        progressDialog?.dismiss()
        dismiss()
        findNavController()?.navigate(R.id.action_global_foundBirdFragment)
        Snackbar.make(
            requireActivity().findViewById(android.R.id.content),
            "บันทึกการแก้ไขแล้ว",
            Snackbar.LENGTH_LONG
        ).show()
    }

    fun failUpdate() {
        progressDialog?.dismiss()
        dismiss()
        findNavController()?.navigate(R.id.action_global_foundBirdFragment)
        Snackbar.make(
            requireActivity().findViewById(android.R.id.content),
            "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
            Snackbar.LENGTH_LONG
        ).show()
    }

    private fun setupFullHeight(bottomSheet: View) {
        val layoutParams = bottomSheet.layoutParams
        layoutParams.height = WindowManager.LayoutParams.MATCH_PARENT
        bottomSheet.layoutParams = layoutParams
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

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_edit_fb_detail_public, container, false)
    }
}