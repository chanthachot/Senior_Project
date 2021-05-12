package com.example.finaproject

import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.GET
import retrofit2.http.Path

interface PathAPI {
    @GET("path")
    fun retrieve_path(): Call<List<PathDB>>

    @GET("qrcode/{point_id}")
    fun retrieve_qrcode(
        @Path("point_id") point_id: Int
    ): Call<List<QRCodeDB>>

    @GET("point/{path_id}")
    fun retrieve_qrpath(
        @Path("path_id") path_id: Int
    ): Call<List<PointDB>>

    companion object {
        fun create(): PathAPI {
            val pathClient: PathAPI = Retrofit.Builder()
                .baseUrl("http://" + ServerIP().server_ip + ":8080")
                .addConverterFactory(GsonConverterFactory.create())
                .build()
                .create(PathAPI::class.java)
            return pathClient
        }
    }
}