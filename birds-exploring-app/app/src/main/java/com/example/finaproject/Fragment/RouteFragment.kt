package com.example.finaproject.Fragment

import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.facebook.shimmer.ShimmerFrameLayout
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_route.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class RouteFragment : Fragment(), path_adapter.ClickListener {

    val routeClient = PathAPI.create()
    var adapter: path_adapter? = null
    val itemsModalList = ArrayList<PathDB>()
    private var shimmerFrameLayout: ShimmerFrameLayout? = null


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        shimmerFrameLayout = shimmerLayoutRoute

        recycler_view_route!!.layoutManager = GridLayoutManager(context, 2)
        recycler_view_route!!.itemAnimator = DefaultItemAnimator() as RecyclerView.ItemAnimator?

    }

    fun callRoute() {

        shimmerFrameLayout!!.startShimmer();

        itemsModalList.clear();
        routeClient.retrieve_path()
            .enqueue(object : Callback<List<PathDB>> {
                override fun onResponse(
                    call: Call<List<PathDB>>,
                    response: Response<List<PathDB>>
                ) {
                    shimmerFrameLayout!!.stopShimmer()
                    shimmerFrameLayout!!.visibility = View.GONE;
                    itemsModalList.clear();
                    response.body()?.forEach {

                        itemsModalList.add(
                            PathDB(
                                it.path_id, it.path_name
                            )
                        )


                    }

                    adapter = path_adapter(
                        itemsModalList,
                        requireContext(),
                        this@RouteFragment
                    )
                    adapter!!.setData(itemsModalList)
                    adapter!!.notifyDataSetChanged()



                    recycler_view_route!!.adapter = adapter

                }


                override fun onFailure(call: Call<List<PathDB>>, t: Throwable) {
                    Snackbar.make(
                        requireActivity().findViewById(android.R.id.content),
                        "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                        Snackbar.LENGTH_LONG
                    ).show()
                }


            })
    }

    override fun onResume() {
        super.onResume()

        callRoute()
    }


    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_route, container, false)
    }

    override fun ClickedItem(pathDB: PathDB) {

        var showRouteMap = ShowRouteMap()

        val bundle = Bundle()
        bundle.putString("path_id", pathDB.path_id)

        showRouteMap.arguments = bundle

        showRouteMap.show(requireActivity().supportFragmentManager, "TAG")

    }

}