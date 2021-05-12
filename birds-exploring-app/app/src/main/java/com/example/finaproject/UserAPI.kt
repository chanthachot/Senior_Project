package com.example.finaproject


import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

interface UserAPI {

    @GET("user/uid/{uid}")
    fun retrieve_user_id(
        @Path("uid") uid: String): Call<List<UserDB>>

    @FormUrlEncoded
    @POST("register")
    fun register(
        @Field("uid") uid: String,
        @Field("first_name") first_name: String,
        @Field("last_name") last_name: String,
        @Field("email") email: String): Call<UserDB>

    companion object {
        fun create(): UserAPI {
            val userClient: UserAPI = Retrofit.Builder()
                .baseUrl("http://" + ServerIP().server_ip + ":8080")
                .addConverterFactory(GsonConverterFactory.create())
                .build()
                .create(UserAPI::class.java)
            return userClient
        }
    }
}