package com.example.finaproject

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.GET
import retrofit2.http.Path

interface BirdAPI {

    @GET("bird_name/{bird_name}")
    fun retrieve_birds_from_bird_name(
        @Path("bird_name") bird_name: String
    ): Call<List<BirdsDB>>

    @GET("birds/{bird_id}")
    fun retrieve_birds(
        @Path("bird_id") bird_id: ArrayList<String>
    ): Call<List<BirdsDB>>

    @GET("bird_family")
    fun retrieve_bird_family(): Call<List<Bird_Family_DB>>

    @GET("birds/bird_family_id/{bird_family_id}")
    fun retrieve_birds_id(
        @Path("bird_family_id") bird_family_id: Int
    ): Call<List<BirdsDB>>

    @GET("bird_detail/bird_id/{bird_id}")
    fun retrieve_bird_detail(
        @Path("bird_id") bird_id: String
    ): Call<List<BirdsDB>>

    companion object{
        fun create():BirdAPI{
            val birdClient:BirdAPI = Retrofit.Builder()
                .baseUrl("http://" + ServerIP().server_ip + ":8080")
                .addConverterFactory(GsonConverterFactory.create())
                .build()
                .create(BirdAPI::class.java)
            return birdClient
        }
    }
}