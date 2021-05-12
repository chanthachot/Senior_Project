package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

class FoundBirdDB(

    //user
    @Expose
    @SerializedName("first_name") val first_name: String,

    @Expose
    @SerializedName("last_name") val last_name: String,

    @Expose
    @SerializedName("email") val email: String,

    //foundbird
    @Expose
    @SerializedName("foundbird_id") val foundbird_id: Int,

    @Expose
    @SerializedName("bird_family_name") val bird_family_name: String,

    @Expose
    @SerializedName("bird_name") val bird_name: String,

    @Expose
    @SerializedName("amount") val amount: String,

    @Expose
    @SerializedName("lat") val lat: String,

    @Expose
    @SerializedName("lng") val lng: String,

    @Expose
    @SerializedName("date") val date: String,

    @Expose
    @SerializedName("time") val time: String,

    @Expose
    @SerializedName("timestamp") val timestamp: String,

    @Expose
    @SerializedName("foundbird_pic_url") val foundbird_pic_url: String,

    @Expose
    @SerializedName("mouth_desc") val mouth: String,

    @Expose
    @SerializedName("body_desc") val body: String,

    @Expose
    @SerializedName("tail_desc") val tail: String,

    @Expose
    @SerializedName("wings_desc") val wings: String,

    @Expose
    @SerializedName("legs_desc") val legs: String,

    @Expose
    @SerializedName("other_desc") val other: String,

    @Expose
    @SerializedName("place") val place: String,

    @Expose
    @SerializedName("uid") val uid: String,

    @Expose
    @SerializedName("type") val type: String

) {
}