package com.example.finaproject.Fragment

import android.os.Bundle
import android.util.Log
import android.view.*
import android.widget.EditText
import androidx.appcompat.widget.SearchView
import androidx.core.view.isVisible
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.navigation.fragment.navArgs
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.facebook.shimmer.ShimmerFrameLayout
import kotlinx.android.synthetic.main.fragment_add_found_bird_public.*
import kotlinx.android.synthetic.main.fragment_bird_family.*
import kotlinx.android.synthetic.main.fragment_birds.*
import kotlinx.android.synthetic.main.fragment_sub_add_found_bird_public.*
import kotlinx.android.synthetic.main.fragment_sub_add_found_bird_public.recycler_view
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import kotlinx.android.synthetic.main.fragment_bird_family.recycler_view as recycler_view1

class SubAddFoundBirdPublic : Fragment(), add_found_bird_bird_adapter.ClickListener {

    val birdClient = BirdAPI.create()
    var adapter: add_found_bird_bird_adapter? = null
    val itemsModalList = ArrayList<BirdsDB>()


    private var shimmerFrameLayout: ShimmerFrameLayout? = null

    val args: SubAddFoundBirdPublicArgs by navArgs()


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

                    adapter = add_found_bird_bird_adapter(itemsModalList, requireContext(), this@SubAddFoundBirdPublic)
                    adapter!!.setData(itemsModalList)
                    recycler_view.adapter = adapter

                }

                override fun onFailure(call: Call<List<BirdsDB>>, t: Throwable) =
                    t.printStackTrace()
            })
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        shimmerFrameLayout = shimmerLayoutSubAddFoundBird

        setHasOptionsMenu(true)
        recycler_view.layoutManager = GridLayoutManager(context ,1)
        recycler_view.itemAnimator = DefaultItemAnimator() as RecyclerView.ItemAnimator?

    }

    override fun onResume() {
        super.onResume()
//        callBirdFirebase()
        callBirdsData()
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

    override fun ClickedItem(birdsDB: BirdsDB) {

        val action = SubAddFoundBirdPublicDirections.actionSubAddFoundBirdPublicToSelectMapInFoundBirdPublic(args.birdFamilyName,birdsDB.bird_name)
        findNavController().navigate(action)
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_sub_add_found_bird_public, container, false)
    }
}