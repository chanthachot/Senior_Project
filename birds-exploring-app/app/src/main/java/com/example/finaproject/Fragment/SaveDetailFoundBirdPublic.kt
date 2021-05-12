package com.example.finaproject.Fragment

import android.Manifest
import android.app.Activity
import android.app.DatePickerDialog
import android.app.ProgressDialog
import android.app.TimePickerDialog
import android.content.ContentValues
import android.content.Intent
import android.content.pm.PackageManager
import android.graphics.Bitmap
import android.graphics.BitmapFactory
import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.net.Uri
import android.os.Bundle
import android.os.Environment
import android.provider.MediaStore
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.View.GONE
import android.view.View.VISIBLE
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.core.content.FileProvider
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.navigation.fragment.navArgs
import coil.api.load
import com.cepheuen.elegantnumberbutton.view.ElegantNumberButton
import com.deishelon.roundedbottomsheet.RoundedBottomSheetDialog
import com.example.finaproject.FoundBirdAPI
import com.example.finaproject.FoundBirdDB
import com.example.finaproject.R
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.storage.FirebaseStorage
import kotlinx.android.synthetic.main.fragment_edit_fb_detail_public.*
import kotlinx.android.synthetic.main.fragment_save_detail_found_bird_public.*
import kotlinx.android.synthetic.main.fragment_save_detail_found_bird_public.elegantBtn
import kotlinx.android.synthetic.main.select_action_image_dialog.view.*
import kotlinx.android.synthetic.main.select_source_image_dialog.view.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.File
import java.io.IOException
import java.text.SimpleDateFormat
import java.util.*
import java.util.Calendar.*
import kotlin.collections.ArrayList


class SaveDetailFoundBirdPublic : Fragment() {

    val DIALOG_FRAGMENT = 1
    val SELECT_SAVE = 101

    private lateinit var select_type: String

    val args: SaveDetailFoundBirdPublicArgs by navArgs()

    private lateinit var imageUri: Uri

    val TAKE_PICTURE = 1
    val SELECT_PICTURE = 2
    private val PERMISSION_REQUEST_CODE = 3

    val getDate = getInstance()
    val year = getDate.get(YEAR)
    var month = getDate.get(MONTH)
    var day = getDate.get(DAY_OF_MONTH)
    val hours = getDate.get(HOUR_OF_DAY)
    val minutes = getDate.get(MINUTE)

    private lateinit var auth: FirebaseAuth

    val foundBirdClient = FoundBirdAPI.create()

    private lateinit var lastFoundbirdId: String

    private var progressDialog: ProgressDialog? = null

    private val arrayPic = ArrayList<Uri>()

    private val arrayUri = ArrayList<String>()

    lateinit var currentPhotoPath: String

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        select_image.setOnClickListener {
            selectActionDialog()
        }

        carouselViewSaveDetail.setImageClickListener {
            selectActionDialog()
        }

        val button = elegantBtn as ElegantNumberButton
        button.number = "1"

        place.setText(args.place)

        date.setOnClickListener {
            datePicker()
        }

        time.setOnClickListener {
            timePicker()
        }

        saveBtn.setOnClickListener {
            postFoundBird()
        }


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
            arrayPic.clear()
            SelectActionImageDialog.dismiss()
            select_image.visibility = VISIBLE
//            showImage.visibility = GONE
            carouselViewSaveDetail.visibility = GONE
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

    fun datePicker() {
        val datePicker = DatePickerDialog(
            requireContext(),
            android.R.style.Theme_Holo_Light_Dialog_MinWidth, { datePicker, mYear, mMonth, mDay ->

                var Day = mDay
                var Month = mMonth

                var nd = "" + Day

                if (Day < 10) {
                    nd = "0" + Day
                }

                if (Month >= 0) {
                    Month += 1
                }

                date.setText("$nd/$Month/$mYear")

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
            android.R.style.Theme_Holo_Light_Dialog_MinWidth, { timePicker, houseOfDay, minute ->

                val timeFromPicker = "" + houseOfDay + ":" + minute;

                val timeFormat = SimpleDateFormat("HH:mm")
                val parse = timeFormat.parse(timeFromPicker)
                time.setText(timeFormat.format(parse))
            }, hours, minutes, true

        )
        timePickerDialog.window!!.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))
        timePickerDialog.show()
    }

    fun postFoundBird() {
        if (date.text.toString().isEmpty()) {
            Snackbar.make(
                requireActivity().findViewById(android.R.id.content),
                "กรุณาเลือกวันที่",
                Snackbar.LENGTH_LONG
            ).show()
            return
        } else if (time.text.toString().isEmpty()) {
            Snackbar.make(
                requireActivity().findViewById(android.R.id.content),
                "กรุณาเลือกเวลา",
                Snackbar.LENGTH_LONG
            ).show()
            return
        }

        ShowSelectOptionDialog()

    }

    private fun ShowSelectOptionDialog() {
        var selectOptionDialog = SelectOptionDialog()
        selectOptionDialog.setTargetFragment(this, DIALOG_FRAGMENT);
        selectOptionDialog.show(
            parentFragmentManager,
            "TAG"
        )
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

    @Throws(IOException::class)
    private fun createImageFile(): File {
        // Create an image file name
        val timeStamp: String = SimpleDateFormat("yyyyMMdd_HHmmss").format(Date())
        val storageDir: File? =
            requireContext().getExternalFilesDir(Environment.DIRECTORY_PICTURES)
        return File.createTempFile(
            "JPEG_${timeStamp}_", /* prefix */
            ".jpg", /* suffix */
            storageDir /* directory */
        ).apply {
            // Save a file: path for use with ACTION_VIEW intents
            currentPhotoPath = absolutePath
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

//        val takePictureIntent = Intent(MediaStore.ACTION_IMAGE_CAPTURE)
//
//        if (takePictureIntent.resolveActivity(requireActivity().packageManager) != null) {
//            // Create the File where the photo should go
//            var photoFile: File? = null
//            try {
//                photoFile = createImageFile()
//            } catch (ex: IOException) {
//              Log.e("error_createImageFile", ex.toString())
//            }
//            // Continue only if the File was successfully created
//            if (photoFile != null) {
//                val photoURI = FileProvider.getUriForFile(
//                    requireContext(), "com.example.finaproject", photoFile
//                )
//                takePictureIntent.putExtra(MediaStore.EXTRA_OUTPUT, photoURI)
//                startActivityForResult(takePictureIntent, TAKE_PICTURE)
//            }
//        }
    }

    fun dispatchGalleryIntent() {
        val intent = Intent()
        intent.type = "image/*"
        intent.action = Intent.ACTION_PICK
        intent.putExtra(Intent.EXTRA_ALLOW_MULTIPLE, true)
        startActivityForResult(Intent.createChooser(intent, "Select Picture"), SELECT_PICTURE)
    }

    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        super.onActivityResult(requestCode, resultCode, data)
        if (requestCode == TAKE_PICTURE && resultCode == Activity.RESULT_OK) {
//            val takenImage = data?.extras?.get("data") as Bitmap
//            select_image.setImageBitmap(takenImage) //ดึงรูปจากกล้องเลย

//            val f = File(currentPhotoPath)
//            val contentUri = Uri.fromFile(f)
//
//            imageUri = contentUri

            arrayPic.add(imageUri)
//            Log.e("imageURi", imageUri.toString())

            select_image.visibility = GONE
            carouselViewSaveDetail.visibility = VISIBLE

            val shimmer = Shimmer.ColorHighlightBuilder()
                .setBaseColor(Color.parseColor("#F3F3F3"))
                .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                .setHighlightAlpha(1F)
                .setDropoff(
                    50F
                ).build()
            val shimmerDrawable = ShimmerDrawable()
            shimmerDrawable.setShimmer(shimmer)

            carouselViewSaveDetail.setImageListener { position, imageView ->
                imageView.load(arrayPic[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewSaveDetail.pageCount = arrayPic.size
        } else {
            super.onActivityResult(requestCode, resultCode, data)
        }

        if (requestCode == SELECT_PICTURE && resultCode == Activity.RESULT_OK && data != null && data.data != null) {
            if (data.clipData != null) {
                for (i in 0 until data.clipData!!.itemCount) {
                    imageUri = data.clipData!!.getItemAt(i).uri
                    arrayPic.add(imageUri)
                }
            } else {
                imageUri = data.data!!
                arrayPic.add(imageUri)
            }

            select_image.visibility = GONE
            carouselViewSaveDetail.visibility = VISIBLE
            //      showImage.visibility = GONE

            val shimmer = Shimmer.ColorHighlightBuilder()
                .setBaseColor(Color.parseColor("#F3F3F3"))
                .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                .setHighlightAlpha(1F)
                .setDropoff(
                    50F
                ).build()
            val shimmerDrawable = ShimmerDrawable()
            shimmerDrawable.setShimmer(shimmer)

            carouselViewSaveDetail.setImageListener { position, imageView ->
                imageView.load(arrayPic[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewSaveDetail.pageCount = arrayPic.size

        } else {
            super.onActivityResult(requestCode, resultCode, data)
        }

        if (resultCode == SELECT_SAVE) {
            progressDialog = ProgressDialog(requireContext())
            progressDialog?.show()
            progressDialog?.setContentView(R.layout.loading)
            progressDialog?.setCanceledOnTouchOutside(false)
            progressDialog?.window!!.setBackgroundDrawableResource(android.R.color.transparent)

            select_type = data!!.getStringExtra("select_save").toString()
            if (select_type != null) {
                if (this::imageUri.isInitialized) {
                    ImageUriInitialized(select_type)
                } else {
                    ImageNotInitialized(select_type)
                }
            }
        }
    }

    private fun ImageUriInitialized(type: String) {
        val currentTimestamp = SimpleDateFormat("ddMMyyyyHHmm").format(Date())

        for (i in 0 until arrayPic.size) {
            val folder =
                FirebaseStorage.getInstance().reference.child("FoundBird")
                    .child(currentTimestamp + System.currentTimeMillis() +(0..10).random() + arrayPic[i].lastPathSegment)
            folder!!.putFile(arrayPic[i]).addOnSuccessListener {
                folder.downloadUrl.addOnSuccessListener { uri ->
                    arrayUri.add(uri.toString())

                    if (arrayPic.size == arrayUri.size) {
                        if (type == "3") {
                            insertFoundBird_Initialized_Public(arrayUri)
                        } else {
                            insertFoundBird_Initialized_Option(type, arrayUri)
                        }
                    }
                }
            }
        }
    }


    fun insertFoundBird_Initialized_Public(url: ArrayList<String>) {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            1.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(call: Call<FoundBirdDB>, response: Response<FoundBirdDB>) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }

                            for (index in 0 until url.size) {
                                foundBirdClient.insertFoundBirdPic(
                                    url[index],
                                    lastFoundbirdId
                                ).enqueue(object : Callback<FoundBirdDB> {
                                    override fun onResponse(
                                        call: Call<FoundBirdDB>,
                                        response: Response<FoundBirdDB>
                                    ) {
                                        if (index == 0) {
                                            insertFoundBird_Initialized_Private(url)
                                        }
                                    }

                                    override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                        failInsertFoundbird()
                                    }
                                })
                            }
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()

                        }
                    })
            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }

        })
    }

    fun insertFoundBird_Initialized_Private(url: ArrayList<String>) {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            2.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }
                            for (index in 0 until url.size) {
                                foundBirdClient.insertFoundBirdPic(
                                    url[index],
                                    lastFoundbirdId
                                ).enqueue(object : Callback<FoundBirdDB> {
                                    override fun onResponse(
                                        call: Call<FoundBirdDB>,
                                        response: Response<FoundBirdDB>
                                    ) {
                                        finishInsertFoundbird()
                                    }

                                    override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                        failInsertFoundbird()
                                    }
                                })
                            }
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()
                        }
                    })

            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }
        })
    }

    fun insertFoundBird_Initialized_Option(type: String, url: ArrayList<String>) {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            type
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }

                            for (index in 0 until url.size) {
                                foundBirdClient.insertFoundBirdPic(url[index], lastFoundbirdId)
                                    .enqueue(object : Callback<FoundBirdDB> {
                                        override fun onResponse(
                                            call: Call<FoundBirdDB>,
                                            response: Response<FoundBirdDB>
                                        ) {
                                            finishInsertFoundbird()
                                        }

                                        override fun onFailure(
                                            call: Call<FoundBirdDB>,
                                            t: Throwable
                                        ) {
                                            failInsertFoundbird()
                                        }
                                    })
                            }
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()
                        }
                    })

            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }

        })
    }


    private fun ImageNotInitialized(type: String) {
        val noImageUrl = "https://jmva.or.jp/wp-content/uploads/2018/07/noimage.png"

        if (type == "3") {
            insertFoundBird_notInitialized_Public(noImageUrl)
        } else {
            insertFoundBird_notInitialized_Option(type, noImageUrl)
        }
    }

    fun insertFoundBird_notInitialized_Public(noImageUrl: String) {

        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            1.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }
                            foundBirdClient.insertFoundBirdPic(
                                noImageUrl,
                                lastFoundbirdId
                            ).enqueue(object : Callback<FoundBirdDB> {
                                override fun onResponse(
                                    call: Call<FoundBirdDB>,
                                    response: Response<FoundBirdDB>
                                ) {
                                    insertFoundBird_notInitialized_Private(noImageUrl)
                                }

                                override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                    failInsertFoundbird()
                                }
                            })
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()
                        }
                    })


            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }
        })
    }

    fun insertFoundBird_notInitialized_Private(noImageUrl: String) {
        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            2.toString()
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }
                            foundBirdClient.insertFoundBirdPic(
                                noImageUrl,
                                lastFoundbirdId
                            ).enqueue(object : Callback<FoundBirdDB> {
                                override fun onResponse(
                                    call: Call<FoundBirdDB>,
                                    response: Response<FoundBirdDB>
                                ) {
                                    finishInsertFoundbird()
                                }

                                override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                    failInsertFoundbird()
                                }
                            })
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()
                        }
                    })

            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }
        })
    }


    fun insertFoundBird_notInitialized_Option(type: String, noImageUrl: String) {

        val button = elegantBtn as ElegantNumberButton
        val currentTimestamp = SimpleDateFormat("dd-MM-yyyy - HH:mm").format(Date())

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        foundBirdClient.insertFoundBird(
            args.birdFamilyName,
            args.birdName,
            button.number,
            args.lat,
            args.lng,
            date.text.toString(),
            time.text.toString(),
            currentTimestamp,
            mouth.text.toString(),
            body.text.toString(),
            tail.text.toString(),
            wings.text.toString(),
            legs.text.toString(),
            other.text.toString(),
            place.text.toString(),
            user!!.uid,
            type
        ).enqueue(object : Callback<FoundBirdDB> {
            override fun onResponse(
                call: Call<FoundBirdDB>,
                response: Response<FoundBirdDB>
            ) {
                auth = FirebaseAuth.getInstance()
                val user = auth.currentUser

                foundBirdClient.retrieve_last_foundbird_id(user!!.uid)
                    .enqueue(object : Callback<List<FoundBirdDB>> {
                        override fun onResponse(
                            call: Call<List<FoundBirdDB>>,
                            response: Response<List<FoundBirdDB>>
                        ) {
                            response.body()?.forEach {
                                lastFoundbirdId = it.foundbird_id.toString()
                            }
                            foundBirdClient.insertFoundBirdPic(
                                noImageUrl,
                                lastFoundbirdId
                            ).enqueue(object : Callback<FoundBirdDB> {
                                override fun onResponse(
                                    call: Call<FoundBirdDB>,
                                    response: Response<FoundBirdDB>
                                ) {
                                    finishInsertFoundbird()
                                }

                                override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                                    failInsertFoundbird()
                                }
                            })
                        }

                        override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                            failInsertFoundbird()
                        }
                    })

            }

            override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                failInsertFoundbird()
            }
        })
    }

    fun finishInsertFoundbird() {
        progressDialog?.dismiss()

        findNavController()?.navigate(R.id.action_global_foundBirdFragment)

        Snackbar.make(
            requireActivity().findViewById(android.R.id.content),
            "บันทึกพบนกแล้ว",
            Snackbar.LENGTH_LONG
        ).show()
    }

    fun failInsertFoundbird() {
        progressDialog?.dismiss()

        findNavController()?.navigate(R.id.action_global_foundBirdFragment)

        Snackbar.make(
            requireActivity().findViewById(android.R.id.content),
            "เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง",
            Snackbar.LENGTH_LONG
        ).show()
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(
            R.layout.fragment_save_detail_found_bird_public,
            container,
            false
        )
    }
}