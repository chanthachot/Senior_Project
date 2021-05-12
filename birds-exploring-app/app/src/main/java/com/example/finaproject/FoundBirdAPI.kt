package com.example.finaproject

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*

interface FoundBirdAPI {
    @GET("foundbird_public")
    fun retrieve_found_bird_public(): Call<List<FoundBirdDB>>

    @GET("foundbird_private/{uid}")
    fun retrieve_found_bird_private(
        @Path("uid") uid: String
    ): Call<List<FoundBirdDB>>

    @GET("foundbird_detail/foundbird_id/{foundbird_id}")
    fun retrieve_found_bird_detail(
        @Path("foundbird_id") foundbird_id: String
    ): Call<List<FoundBirdDB>>

    @FormUrlEncoded
    @POST("insertfoundbird")
    fun insertFoundBird(
        @Field("bird_family_name") user_name: String,
        @Field("bird_name") username: String,
        @Field("amount") amount: String,
        @Field("lat") lat: String,
        @Field("lng") lng: String,
        @Field("date") date: String,
        @Field("time") time: String,
        @Field("timestamp") timestamp: String,
        @Field("mouth_desc") mouth_desc: String,
        @Field("body_desc") body_desc: String,
        @Field("tail_desc") tail_desc: String,
        @Field("wings_desc") wings_desc: String,
        @Field("legs_desc") legs_desc: String,
        @Field("other_desc") other_desc: String,
        @Field("place") place: String,
        @Field("uid") uid: String,
        @Field("type") type: String
    ): Call<FoundBirdDB>

    @GET("retrievelastfoundbirdid/{uid}")
    fun retrieve_last_foundbird_id(@Path("uid") uid : String): Call<List<FoundBirdDB>>

    @FormUrlEncoded
    @POST("insertfoundbirdpic")
    fun insertFoundBirdPic(
        @Field("foundbird_pic_url") foundbird_pic_url: String,
        @Field("foundbird_id") foundbird_id: String
    ): Call<FoundBirdDB>

    @FormUrlEncoded
    @PUT("updatefoundbird/{foundbird_id}")
    fun updateFoundBird(
        @Path("foundbird_id") foundbird_id: Int,
        @Field("bird_family_name") bird_family_name: String,
        @Field("bird_name") bird_name: String,
        @Field("amount") amount: String,
        @Field("lat") lat: String,
        @Field("lng") lng: String,
        @Field("date") date: String,
        @Field("time") time: String,
        @Field("mouth_desc") mouth_desc: String,
        @Field("body_desc") body_desc: String,
        @Field("tail_desc") tail_desc: String,
        @Field("wings_desc") wings_desc: String,
        @Field("legs_desc") legs_desc: String,
        @Field("other_desc") other_desc: String,
        @Field("place") place: String
    ): Call<FoundBirdDB>

    @DELETE("deletefoundbird/{foundbird_id}")
    fun deleteFoundbird(
        @Path("foundbird_id") foundbird_id: Int
    ): Call<FoundBirdDB>

    companion object {
        fun create(): FoundBirdAPI {
            val foundBirdClient: FoundBirdAPI = Retrofit.Builder()
                .baseUrl("http://" + ServerIP().server_ip + ":8080")
                .addConverterFactory(GsonConverterFactory.create())
                .build()
                .create(FoundBirdAPI::class.java)
            return foundBirdClient
        }
    }
}