package com.example.finaproject.Fragment

import android.app.ProgressDialog
import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.util.Log
import android.view.*
import android.widget.Toast
import androidx.core.view.MenuCompat
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.navArgs
import cn.pedant.SweetAlert.SweetAlertDialog
import coil.api.load
import com.bumptech.glide.Glide
import com.example.finaproject.*
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.google.android.material.bottomsheet.BottomSheetDialog
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.database.DatabaseReference
import com.google.firebase.database.FirebaseDatabase
import com.synnapps.carouselview.ImageClickListener
import kotlinx.android.synthetic.main.fragment_bird_detail.*
import kotlinx.android.synthetic.main.fragment_edit_fb_detail_public.*
import kotlinx.android.synthetic.main.fragment_edit_fb_detail_public.view.*
import kotlinx.android.synthetic.main.fragment_fbpublic_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class fbpublic_detail_fragment : Fragment() {

    private lateinit var auth: FirebaseAuth

    val args: fbpublic_detail_fragmentArgs by navArgs()

    val foundBirdClient = FoundBirdAPI.create()

    val itemsModalList = ArrayList<FoundBirdDB>()

    val arrayPic = ArrayList<String>()

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        setHasOptionsMenu(true)

        tv_bird_name_detail.text = args.birdName
        tv_bird_family_name_detail.text = args.birdFamilyName
        tv_firstname_detail.text = args.firstname
        tv_lastname_detail.text = args.lastname
        tv_amount_detail.text = args.amount
        tv_place_detail.text = args.place
        tv_date_detail.text = args.date
        tv_time_detail.text = args.time
        tv_mouth.text = args.mouth
        tv_body.text = args.body
        tv_wings.text = args.wings
        tv_legs.text = args.legs
        tv_tail.text = args.tail
        tv_other.text = args.other

        iv_map.setOnClickListener{
            var ViewMapFoundbirdPublic = ViewMapFoundbirdPublic()

            val bundle = Bundle()
            bundle.putString("birdName", args.birdName)
            bundle.putString("lat", args.lat)
            bundle.putString("lng", args.lng)
            bundle.putString("amount", args.amount)

            ViewMapFoundbirdPublic.arguments = bundle


            ViewMapFoundbirdPublic.show(requireActivity().supportFragmentManager, "TAG")

        }
    }
    override fun onResume() {
        super.onResume()
        callFoundBirdDetailData()
    }

    fun callFoundBirdDetailData() {
        val foundbird_id = args.foundbirdId
        itemsModalList.clear();
        arrayPic.clear();

        foundBirdClient.retrieve_found_bird_detail(foundbird_id.toString())
            .enqueue(object : Callback<List<FoundBirdDB>> {
                override fun onResponse(
                    call: Call<List<FoundBirdDB>>,
                    response: Response<List<FoundBirdDB>>
                ) {
                    response.body()?.forEach {
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
                        val shimmer = Shimmer.ColorHighlightBuilder()
                            .setBaseColor(Color.parseColor("#F3F3F3"))
                            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                            .setHighlightAlpha(1F)
                            .setDropoff(
                                50F
                            ).build()
                        val shimmerDrawable = ShimmerDrawable()
                        shimmerDrawable.setShimmer(shimmer)

                        arrayPic.add(it.foundbird_pic_url)

                        carouselViewFoundBirdPublic.setImageListener { position, imageView ->
                            imageView.load(arrayPic[position]) {
                                placeholder(shimmerDrawable)
                                crossfade(true)
                            }
                        }
                        carouselViewFoundBirdPublic.pageCount = arrayPic.size

                        carouselViewFoundBirdPublic.setImageClickListener { bird_pic_url_position ->
                            val intent = Intent(requireContext(), ViewPictureActivity::class.java)
                            intent.putStringArrayListExtra("bird_pic_url", arrayPic)
                            startActivity(intent)
                        }

                    }

                }

                override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
                    val shimmer = Shimmer.ColorHighlightBuilder()
                        .setBaseColor(Color.parseColor("#F3F3F3"))
                        .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                        .setHighlightAlpha(1F)
                        .setDropoff(
                            50F
                        ).build()
                    val shimmerDrawable = ShimmerDrawable()
                    shimmerDrawable.setShimmer(shimmer)

                    carouselViewFoundBirdPublic.setImageListener { position, imageView ->
                        imageView.load("http://" + ServerIP().server_ip + "/birds-exploring/backend/birddb/dist/noimage.jpg") {
                            placeholder(shimmerDrawable)
                            crossfade(true)
                        }
                    }
                }
            })
    }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment

        return inflater.inflate(R.layout.fragment_fbpublic_detail, container, false)
    }

    override fun onCreateOptionsMenu(menu: Menu, inflater: MenuInflater) {
        inflater.inflate(R.menu.nav_menu, menu)
        menu.findItem(R.id.setting_btn).isVisible = false
        menu.findItem(R.id.edit_btn).isVisible = false


        MenuCompat.setGroupDividerEnabled(menu, true);

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser


        if (args.uid == user!!.uid){
            menu.findItem(R.id.edit_btn).isVisible = true
            menu.findItem(R.id.setting_btn).isVisible = true
        }


        super.onCreateOptionsMenu(menu, inflater)
    }

    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        val id = item.itemId
        if (id == R.id.edit_btn) {

            var editFbDetailPublic = edit_fb_detail_public()

            val bundle = Bundle()
            bundle.putString("foundbirdid", args.foundbirdId.toString())
            bundle.putStringArrayList("birdpic", arrayPic)
            bundle.putString("birdName", args.birdName)
            bundle.putString("birdfamilyname", args.birdFamilyName)
            bundle.putString("place", args.place)
            bundle.putString("lat", args.lat)
            bundle.putString("lng", args.lng)
            bundle.putString("date", args.date)
            bundle.putString("time", args.time)
            bundle.putString("mouth", args.mouth)
            bundle.putString("body", args.body)
            bundle.putString("wings", args.wings)
            bundle.putString("legs", args.legs)
            bundle.putString("tail", args.tail)
            bundle.putString("other", args.other)
            bundle.putString("amount", args.amount)

            editFbDetailPublic.arguments = bundle


            editFbDetailPublic.show(requireActivity().supportFragmentManager, "TAG")
        }
        if (id == R.id.delete_btn) {
            val sweet_warning = SweetAlertDialog(requireContext(), SweetAlertDialog.WARNING_TYPE)
            sweet_warning.setCanceledOnTouchOutside(false)
            sweet_warning.setContentText("คุณแน่ใจหรือไม่ว่าต้องการลบรายการนี้")
                .setCancelText("ไม่")
                .setCancelClickListener(SweetAlertDialog.OnSweetClickListener {
                    it.dismissWithAnimation()
                })
                .setConfirmText("ใช่")
                .setConfirmClickListener(SweetAlertDialog.OnSweetClickListener {

                    val progressDialog = ProgressDialog(requireContext())
                    progressDialog.show()
                    progressDialog.setContentView(R.layout.loading)
                    progressDialog.setCanceledOnTouchOutside(false)
                    progressDialog.window!!.setBackgroundDrawableResource(android.R.color.transparent)



                    foundBirdClient.deleteFoundbird(
                        args.foundbirdId
                    ).enqueue(object : Callback<FoundBirdDB> {
                        override fun onResponse(
                            call: Call<FoundBirdDB>,
                            response: Response<FoundBirdDB>
                        ) {
                            sweet_warning.dismiss()
                            progressDialog.dismiss()
                            requireActivity().onBackPressed()
                            Snackbar.make(requireActivity().findViewById(android.R.id.content),"ลบเรียบร้อยแล้ว", Snackbar.LENGTH_LONG).show()
                        }

                        override fun onFailure(call: Call<FoundBirdDB>, t: Throwable) {
                            sweet_warning.dismiss()
                            progressDialog.dismiss()
                            requireActivity().onBackPressed()
                            Snackbar.make(requireActivity().findViewById(android.R.id.content),"เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง", Snackbar.LENGTH_LONG).show()

                        }

                    })
                })
                .show()
        }
        return super.onOptionsItemSelected(item)
    }
}