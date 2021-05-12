package com.example.finaproject.Fragment

import android.content.Intent
import android.graphics.Color
import android.os.Bundle
import android.util.Log
import android.view.*
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.navArgs
import coil.api.load
import com.example.finaproject.*
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.synnapps.carouselview.ImageClickListener
import kotlinx.android.synthetic.main.fragment_bird_detail.*
import kotlinx.android.synthetic.main.fragment_birds.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class BirdDetailFragment : Fragment() {

    val args: BirdDetailFragmentArgs by navArgs()

    val birdClient = BirdAPI.create()
    val itemsModalList = ArrayList<BirdsDB>()

    val arrayPic = ArrayList<String>()

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        setHasOptionsMenu(true)

    }

    override fun onResume() {
        super.onResume()
        callBirdDetailData()
    }

    fun callBirdDetailData() {
        val bird_id = args.birdId
        itemsModalList.clear();
        arrayPic.clear();

        birdClient.retrieve_bird_detail(bird_id)
            .enqueue(object : Callback<List<BirdsDB>> {
                override fun onResponse(
                    call: Call<List<BirdsDB>>,
                    response: Response<List<BirdsDB>>
                ) {
                    response.body()?.forEach {
                        itemsModalList.add(
                            BirdsDB(
                                it.bird_id,
                                it.bird_name,
                                it.bird_commonname,
                                it.bird_sciname,
                                it.bird_description,
                                it.bird_habitat,
                                it.bird_family_name,
                                it.bird_pic_name
                            )
                        )
                        tv_bird_name.text = it.bird_name
                        tv_bird_commonname.text = it.bird_commonname
                        tv_bird_sciname.text = it.bird_sciname
                        tv_bird_family_name.text = it.bird_family_name
                        tv_bird_description.text = it.bird_description
                        tv_bird_habitat.text = it.bird_habitat

                        val shimmer = Shimmer.ColorHighlightBuilder()
                            .setBaseColor(Color.parseColor("#F3F3F3"))
                            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                            .setHighlightAlpha(1F)
                            .setDropoff(
                                50F
                            ).build()
                        val shimmerDrawable = ShimmerDrawable()
                        shimmerDrawable.setShimmer(shimmer)

                        arrayPic.add("http://" + ServerIP().server_ip + "/birds-exploring/backend/birddb/dist/birds_img/" + it.bird_pic_name)

                        carouselView.setImageListener { position, imageView ->
                            imageView.load(arrayPic[position]) {
                                placeholder(shimmerDrawable)
                                crossfade(true)
                            }
                        }
                        carouselView.pageCount = arrayPic.size

                        carouselView.setImageClickListener { bird_pic_position ->
                            val intent = Intent(requireContext(), ViewPictureActivity::class.java)
                            intent.putStringArrayListExtra("bird_pic", arrayPic)
                            startActivity(intent)
                        }

                    }

                }

                override fun onFailure(call: Call<List<BirdsDB>>, t: Throwable) {
                    val shimmer = Shimmer.ColorHighlightBuilder()
                        .setBaseColor(Color.parseColor("#F3F3F3"))
                        .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                        .setHighlightAlpha(1F)
                        .setDropoff(
                            50F
                        ).build()
                    val shimmerDrawable = ShimmerDrawable()
                    shimmerDrawable.setShimmer(shimmer)

                    carouselView.setImageListener { position, imageView ->
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
        return inflater.inflate(R.layout.fragment_bird_detail, container, false)
    }

}