package com.example.finaproject

import android.graphics.Color
import android.net.Uri
import android.os.Bundle
import android.util.Log
import android.widget.ImageView
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.isVisible
import coil.api.load
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import kotlinx.android.synthetic.main.activity_view_picture.*

class ViewPictureActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_view_picture)

        val bird_pic = intent.getStringArrayListExtra("bird_pic")
        val bird_pic_url = intent.getStringArrayListExtra("bird_pic_url")

        val shimmer = Shimmer.ColorHighlightBuilder().setBaseColor(Color.parseColor("#F3F3F3"))
            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7")).setHighlightAlpha(1F)
            .setDropoff(
                50F
            ).build()
        val shimmerDrawable = ShimmerDrawable()
        shimmerDrawable.setShimmer(shimmer)

        if (bird_pic != null) {
            carouselViewFull.isVisible = true
            carouselViewFull.setImageListener { position, imageView ->
                imageView.scaleType = ImageView.ScaleType.FIT_CENTER
                imageView.load(bird_pic[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewFull.pageCount = bird_pic.size
//
//            carouselViewFull.setOnClickListener{
//                finish()
//            }
        }
        if (bird_pic_url != null) {
            carouselViewFull.isVisible = true
            carouselViewFull.setImageListener { position, imageView ->
                imageView.scaleType = ImageView.ScaleType.FIT_CENTER
                imageView.load(bird_pic_url[position]) {
                    placeholder(shimmerDrawable)
                    crossfade(true)
                }
            }
            carouselViewFull.pageCount = bird_pic_url.size
//            full_image_url_view.setOnClickListener {
//                finish()
//            }
        }

    }
}