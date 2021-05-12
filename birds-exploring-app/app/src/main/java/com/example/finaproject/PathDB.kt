package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

data class PathDB (

    @Expose
    @SerializedName("path_id") val path_id: String,

    @Expose
    @SerializedName("path_name") val path_name: String

) {
}