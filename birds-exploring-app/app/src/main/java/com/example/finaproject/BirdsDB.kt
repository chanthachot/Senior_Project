package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

data class BirdsDB (

    @Expose
    @SerializedName("bird_id") val bird_id: String,

    @Expose
    @SerializedName("bird_name") val bird_name: String,
//
    @Expose
    @SerializedName("bird_commonname") val bird_commonname: String,
//
    @Expose
    @SerializedName("bird_sciname") val bird_sciname: String,

    @Expose
    @SerializedName("bird_description") val bird_description: String,

    @Expose
    @SerializedName("bird_habitat") val bird_habitat: String,

    @Expose
    @SerializedName("bird_family_name") val bird_family_name: String,

    @Expose
    @SerializedName("bird_pic_name") val bird_pic_name: String

) {
}