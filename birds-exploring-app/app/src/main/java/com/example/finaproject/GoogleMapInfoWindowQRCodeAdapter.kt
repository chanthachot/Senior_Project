package com.example.finaproject


import android.app.Activity
import android.content.Context
import android.graphics.Color
import android.util.Log
import android.view.View
import android.view.View.GONE
import android.view.View.VISIBLE
import com.example.finaproject.Fragment.InfoWindowData
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import com.google.android.gms.maps.GoogleMap
import com.google.android.gms.maps.model.Marker
import com.squareup.picasso.Callback
import com.squareup.picasso.Picasso
import kotlinx.android.synthetic.main.info_window_qrcode.view.*


class GoogleMapInfoWindowQRCodeAdapter(var context: Context) : GoogleMap.InfoWindowAdapter {


    var mWindow = (context as Activity).layoutInflater.inflate(R.layout.info_window_qrcode, null)

    private fun content(marker: Marker, view: View) {

        val point_name = view.point_name
        val timestamp = view.timestamp
        val iv_qrcode = view.iv_qrcode
        val text_qrcode = view.text_qrcode

        val InfoWindowData = marker.tag as InfoWindowData?
//
        if (InfoWindowData != null) {
            point_name.text = InfoWindowData!!.point_name
            timestamp.text = InfoWindowData!!.qrcode_timestamp
            iv_qrcode.visibility = VISIBLE
            text_qrcode.text = "รูปคิวอาร์โค้ดล่าสุด"

            val shimmer = Shimmer.ColorHighlightBuilder().setBaseColor(Color.parseColor("#F3F3F3"))
                .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7"))
                .setHighlightAlpha(1F)
                .setDropoff(
                    50F
                ).build()
            val shimmerDrawable = ShimmerDrawable()
            shimmerDrawable.setShimmer(shimmer)


            val url_bird_qrcode =
                "http://" + ServerIP().server_ip + "/birds-exploring/backend/qrcode/qrcodelib/userQr/" + InfoWindowData!!.qrcode_image

            Picasso.with(context)
                .load(url_bird_qrcode)
                .placeholder(shimmerDrawable)
                .into(iv_qrcode, object : Callback {
                    override fun onSuccess() {
                        if (marker != null && marker.isInfoWindowShown) {
                            marker.hideInfoWindow()
                            marker.showInfoWindow()
                        }
                    }

                    override fun onError() {
                        Log.e("Error Load Pic", "Error Load Pic")
                    }
                })
        } else {
            text_qrcode.text = "ยังไม่มีข้อมูลคิวอาร์โค้ด"
            point_name.text = marker.title
            timestamp.text = "ยังไม่มีข้อมูลคิวอาร์โค้ด"
            iv_qrcode.visibility = GONE
        }
    }

    override fun getInfoWindow(marker: Marker): View {
        content(marker, mWindow)
        return mWindow
    }

    override fun getInfoContents(marker: Marker): View {
        content(marker, mWindow)
        return mWindow
    }

}