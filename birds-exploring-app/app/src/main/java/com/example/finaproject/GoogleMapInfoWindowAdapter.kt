package com.example.finaproject


import android.app.Activity
import android.content.Context
import android.graphics.Color
import android.util.Log
import android.view.View
import com.example.finaproject.Fragment.InfoWindowData
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.model.Marker
import com.squareup.picasso.Callback
import com.squareup.picasso.Picasso
import kotlinx.android.synthetic.main.info_window.view.*


class GoogleMapInfoWindowAdapter(var context: Context) : GoogleMap.InfoWindowAdapter {


    var mWindow = (context as Activity).layoutInflater.inflate(R.layout.info_window, null)

    private fun rendowWindowText(marker: Marker, view: View) {

        val bird_name = view.bird_name
        val bird_family_name = view.bird_family_name
        val bird_sciname = view.bird_sciname
        val iv_bird_info_window = view.iv_bird_info_window

        val infoWindowData = marker.tag as InfoWindowData?

        bird_name.text = infoWindowData!!.bird_name
        bird_family_name.text = infoWindowData!!.bird_family_name
        bird_sciname.text = infoWindowData!!.bird_sciname

        val shimmer = Shimmer.ColorHighlightBuilder().setBaseColor(Color.parseColor("#F3F3F3"))
            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
            .setHighlightAlpha(1F)
            .setDropoff(
                50F
            ).build()
        val shimmerDrawable = ShimmerDrawable()
        shimmerDrawable.setShimmer(shimmer)

        val url_bird_pic =
            "http://" + ServerIP().server_ip + "/birds-exploring/backend/birddb/dist/birds_img/" + infoWindowData!!.bird_pic_name

        Picasso.with(context)
            .load(url_bird_pic)
            .placeholder(shimmerDrawable)
            .into(iv_bird_info_window, object : Callback {
                override fun onSuccess() {
                    if (marker != null && marker.isInfoWindowShown) {
                        marker.hideInfoWindow()
                        marker.showInfoWindow()
                    }
                }

                override fun onError() {
                    Log.e("Error", "Error")
                }
            })
    }

    override fun getInfoWindow(marker: Marker): View {
        rendowWindowText(marker, mWindow)
        return mWindow
    }

    override fun getInfoContents(marker: Marker): View {
        rendowWindowText(marker, mWindow)
        return mWindow
    }

}