package com.example.finaproject.Fragment

import android.graphics.Color
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.facebook.shimmer.ShimmerFrameLayout
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import kotlinx.android.synthetic.main.fragment_found_bird_private.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class FoundBirdPrivateFragment : Fragment(), foundbirdprivate_adapter.ClickListener {

    val foundBirdClient = FoundBirdAPI.create()
    var adapter: foundbirdprivate_adapter? = null
    val itemsModalList = ArrayList<FoundBirdDB>()

    private lateinit var auth: FirebaseAuth

    private var shimmerFrameLayout: ShimmerFrameLayout? = null


    private fun callFoundBird() {
        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        shimmerFrameLayout!!.startShimmer();

        itemsModalList.clear();
        foundBirdClient.retrieve_found_bird_private(user!!.uid)
            .enqueue(object : Callback<List<FoundBirdDB>> {
                override fun onResponse(
                    call: Call<List<FoundBirdDB>>,
                    response: Response<List<FoundBirdDB>>
                ) {
                    shimmerFrameLayout!!.stopShimmer()
                    shimmerFrameLayout!!.visibility = View.GONE;
                    refreshlayout!!.isRefreshing = false
                    itemsModalList.clear();
                    response.body()?.forEach {
                        itemsModalList.add(
                            FoundBirdDB(
                                it.first_name,
                                it.last_name,
                                it.email,
                                it.foundbird_id,
                                it.bird_family_name,
                                it.bird_name,
                                it.amount,
                                it.lat,
                                it.lng,
                                it.date,
                                it.time,
                                it.timestamp,
                                it.foundbird_pic_url,
                                it.mouth,
                                it.body,
                                it.tail,
                                it.wings,
                                it.legs,
                                it.other,
                                it.place,
                                it.uid,
                                it.type
                            )
                        )

                    }

                    adapter = foundbirdprivate_adapter(
                        itemsModalList,
                        requireContext(),
                        this@FoundBirdPrivateFragment
                    )
                    adapter!!.setData(itemsModalList)
                    adapter!!.notifyDataSetChanged()
                    recycler_view_foundbirdprivate!!.adapter = adapter
                }

                override fun onFailure(call: Call<List<FoundBirdDB>>, t: Throwable) {
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
        callFoundBird()
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        shimmerFrameLayout = shimmerLayoutFB

        refreshlayout!!.setOnRefreshListener {
            callFoundBird()
        }

        refreshlayout.setColorSchemeColors(
            Color.parseColor("#d95c4c")
        )


        recycler_view_foundbirdprivate!!.layoutManager =
            LinearLayoutManager(requireContext(), LinearLayoutManager.VERTICAL, false)
        recycler_view_foundbirdprivate!!.itemAnimator =
            DefaultItemAnimator() as RecyclerView.ItemAnimator?
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_found_bird_private, container, false)
    }

    override fun ClickedItem(foundBirdDB: FoundBirdDB) {

        val action =
            FoundBirdFragmentDirections.actionFoundBirdFragmentToFbprivateDetailFragment(
                foundBirdDB.foundbird_id,
                foundBirdDB.first_name,
                foundBirdDB.last_name,
                foundBirdDB.email,
                foundBirdDB.bird_family_name,
                foundBirdDB.bird_name,
                foundBirdDB.amount,
                foundBirdDB.lat,
                foundBirdDB.lng,
                foundBirdDB.date,
                foundBirdDB.time,
                foundBirdDB.mouth,
                foundBirdDB.body,
                foundBirdDB.tail,
                foundBirdDB.wings,
                foundBirdDB.legs,
                foundBirdDB.other,
                foundBirdDB.place,
                foundBirdDB.uid
            )
        findNavController().navigate(action)

    }


}