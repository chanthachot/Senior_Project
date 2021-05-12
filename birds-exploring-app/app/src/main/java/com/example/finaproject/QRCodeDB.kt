package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

data class QRCodeDB(

    @Expose
    @SerializedName("point_id") val point_id: String,

    @Expose
    @SerializedName("point_name") val point_name: String,

    @Expose
    @SerializedName("path_id") val path_id: String,

    @Expose
    @SerializedName("point_lat") val point_lat: String,

    @Expose
    @SerializedName("point_lng") val point_lng: String,

    @Expose
    @SerializedName("qrcode_id") val qrcode_id: String,

    @Expose
    @SerializedName("qrcode_image") val qrcode_image: String,

    @Expose
    @SerializedName("qrcode_timestamp") val qrcode_timestamp: String

    ) {
}