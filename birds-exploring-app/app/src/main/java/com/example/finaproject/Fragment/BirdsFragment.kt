package com.example.finaproject.Fragment

import android.graphics.Color
import android.os.Bundle
import android.os.Handler
import android.util.Log
import android.view.*
import android.widget.EditText
import android.widget.Toast
import androidx.appcompat.widget.SearchView
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.navigation.fragment.navArgs
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.example.finaproject.R
import com.facebook.shimmer.ShimmerFrameLayout
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.database.*
import kotlinx.android.synthetic.main.fragment_bird_family.*
import kotlinx.android.synthetic.main.fragment_birds.*
import kotlinx.android.synthetic.main.fragment_found_bird.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class BirdsFragment : Fragment(), Bird_Adapter.ClickListener {

    val birdClient = BirdAPI.create()
    var adapter: Bird_Adapter? = null
    val itemsModalList = ArrayList<BirdsDB>()

    val args: BirdsFragmentArgs by navArgs()

    private var shimmerFrameLayout: ShimmerFrameLayout? = null


    fun callBirdsData() {
        shimmerFrameLayout!!.startShimmer();

        val id = args.id
        itemsModalList.clear();
        birdClient.retrieve_birds_id(id)
            .enqueue(object : Callback<List<BirdsDB>> {
                override fun onResponse(
                    call: Call<List<BirdsDB>>,
                    response: Response<List<BirdsDB>>
                ) {
                    shimmerFrameLayout!!.stopShimmer()
                    shimmerFrameLayout!!.visibility = View.GONE;
                    response.body()?.forEach {
                        itemsModalList.add(
                            BirdsDB(
                                it.bird_id,
                                it.bird_name,
                                it.bird_commonname,
                                it.bird_sciname,
                                it.bird_description,
                                it.bird_habitat,
                                it.bird_family_name,
                                it.bird_pic_name
                            )
                        )
                    }

                    adapter = Bird_Adapter(itemsModalList, requireContext(), this@BirdsFragment)
                    adapter!!.setData(itemsModalList)
                    adapter!!.notifyDataSetChanged()
                    recycler_view_birds!!.adapter = adapter
                }

                override fun onFailure(call: Call<List<BirdsDB>>, t: Throwable) {
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
//        callBirdFirebase()
        callBirdsData()
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        shimmerFrameLayout = shimmerLayoutBirds

        setHasOptionsMenu(true)


        val bird_family_name_args = args.birdFamilyName
        birds_name.setText(bird_family_name_args)



        recycler_view_birds!!.layoutManager = GridLayoutManager(context, 2)
        recycler_view_birds!!.itemAnimator = DefaultItemAnimator() as RecyclerView.ItemAnimator?
    }

    override fun onCreateOptionsMenu(menu: Menu, inflater: MenuInflater) {
        inflater!!.inflate(R.menu.search_menu, menu)
        val menuItem = menu!!.findItem(R.id.search_icon)

        if (menuItem !== null) {
            val searchView = menuItem.actionView as SearchView
            val editext = searchView.findViewById<EditText>(androidx.appcompat.R.id.search_src_text)
            editext.hint = "ค้นหา"
            searchView.maxWidth = Int.MAX_VALUE
            searchView.setOnQueryTextListener(object : SearchView.OnQueryTextListener {
                override fun onQueryTextSubmit(p0: String?): Boolean {
                    adapter!!.filter.filter(p0)
                    return false
                }

                override fun onQueryTextChange(p0: String?): Boolean {
                    adapter!!.filter.filter(p0)
                    return false
                }
            })


        }
        super.onCreateOptionsMenu(menu, inflater)
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_birds, container, false)

    }

    override fun ClickedItem(birdsDB: BirdsDB) {

        val action = BirdsFragmentDirections.actionBirdsFragmentToBirdDetailFragment(birdsDB.bird_id)
        findNavController().navigate(action)
    }
}