package com.example.finaproject

import com.google.gson.annotations.Expose
import com.google.gson.annotations.SerializedName

class UserDB (
    @Expose
    @SerializedName("user_id") val user_id: Int,

    @Expose
    @SerializedName("uid") val uid: String,

    @Expose
    @SerializedName("first_name") val first_name: String,

    @Expose
    @SerializedName("last_name") val last_name: String,

    @Expose
    @SerializedName("image") val image: String,

    @Expose
    @SerializedName("email") val email: String ){


}