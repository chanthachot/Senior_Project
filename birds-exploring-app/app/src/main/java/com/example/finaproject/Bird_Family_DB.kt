package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

data class Bird_Family_DB (

    @Expose
    @SerializedName("bird_family_id") val bird_family_id: String,

    @Expose
    @SerializedName("bird_family_name") val bird_family_name: String,

    @Expose
    @SerializedName("bird_family_pic") val bird_family_pic: String) {
}