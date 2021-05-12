package com.example.finaproject.Fragment

import android.os.Bundle
import android.util.Log
import android.view.*
import android.widget.EditText
import androidx.appcompat.widget.SearchView
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.facebook.shimmer.ShimmerFrameLayout
import kotlinx.android.synthetic.main.fragment_add_found_bird_public.*
import kotlinx.android.synthetic.main.fragment_bird_family.*
import kotlinx.android.synthetic.main.fragment_bird_family.recycler_view
import kotlinx.android.synthetic.main.fragment_birds.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class AddFoundBirdPublic : Fragment(), add_found_bird_bird_family_adapter.ClickListener {

    val birdClient = BirdAPI.create()
    var adapter: add_found_bird_bird_family_adapter? = null
    val itemsModalList = ArrayList<Bird_Family_DB>()

    private var shimmerFrameLayout: ShimmerFrameLayout? = null

    fun callBirdFamilyData() {
        shimmerFrameLayout!!.startShimmer();
        itemsModalList.clear();
        birdClient.retrieve_bird_family()
            .enqueue(object : Callback<List<Bird_Family_DB>> {
                override fun onResponse(
                    call: Call<List<Bird_Family_DB>>,
                    response: Response<List<Bird_Family_DB>>
                ) {
                    shimmerFrameLayout!!.stopShimmer()
                    shimmerFrameLayout!!.visibility = View.GONE;
                    response.body()?.forEach {
                        itemsModalList.add(Bird_Family_DB(it.bird_family_id, it.bird_family_name
                            , it.bird_family_pic))

                    }

                    adapter = add_found_bird_bird_family_adapter(itemsModalList, requireContext(), this@AddFoundBirdPublic)
                    adapter!!.setData(itemsModalList)
                    adapter!!.notifyDataSetChanged()
                    recycler_view.adapter = adapter
                }

                override fun onFailure(call: Call<List<Bird_Family_DB>>, t: Throwable) =
                    t.printStackTrace()
            })
    }

    override fun onResume() {
        super.onResume()
        callBirdFamilyData()
    }


    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        shimmerFrameLayout = shimmerLayoutAddFoundBird

        setHasOptionsMenu(true)
        recycler_view.layoutManager = GridLayoutManager(context ,1)
        recycler_view.itemAnimator = DefaultItemAnimator() as RecyclerView.ItemAnimator?
    }

    override fun onCreateOptionsMenu(menu: Menu, inflater: MenuInflater) {
        inflater!!.inflate(R.menu.search_menu, menu)
        val menuItem = menu!!.findItem(R.id.search_icon)

        if(menuItem !== null){
            val searchView = menuItem.actionView as SearchView
            val editext = searchView.findViewById<EditText>(androidx.appcompat.R.id.search_src_text)
            editext.hint = "ค้นหา"
            searchView.maxWidth = Int.MAX_VALUE
            searchView.setOnQueryTextListener(object : SearchView.OnQueryTextListener{
                override fun onQueryTextSubmit(p0: String?): Boolean {
                    adapter!!.filter.filter(p0)
                    return true
                }

                override fun onQueryTextChange(p0: String?): Boolean {
                    adapter!!.filter.filter(p0)
                    return true
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
        return inflater.inflate(R.layout.fragment_add_found_bird_public, container, false)
    }

    override fun ClickedItem(birdFamilyDb: Bird_Family_DB) {

        val action = AddFoundBirdPublicDirections.actionAddFoundBirdPublicToSubAddFoundBirdPublic(birdFamilyDb.bird_family_id.toInt(),birdFamilyDb.bird_family_name)
        findNavController().navigate(action)

    }
}