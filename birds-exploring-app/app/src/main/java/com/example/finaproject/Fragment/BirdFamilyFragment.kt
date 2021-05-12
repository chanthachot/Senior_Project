package com.example.finaproject.Fragment

import android.app.Activity
import android.content.Intent
import android.os.Bundle
import android.os.Parcelable
import android.view.*
import android.widget.EditText
import androidx.appcompat.widget.SearchView
import androidx.databinding.DataBindingUtil.setContentView
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.GridLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.BirdAPI
import com.example.finaproject.Bird_Family_Adapter
import com.example.finaproject.Bird_Family_DB
import com.example.finaproject.R
import com.facebook.shimmer.ShimmerFrameLayout
import com.google.android.material.snackbar.Snackbar
import com.google.zxing.integration.android.IntentIntegrator
import kotlinx.android.synthetic.main.fragment_bird_family.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class BirdFamilyFragment : Fragment(), Bird_Family_Adapter.ClickListener {

    val birdClient = BirdAPI.create()
    var adapter: Bird_Family_Adapter? = null
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
                    itemsModalList.clear();
                    response.body()?.forEach {
                        itemsModalList.add(
                            Bird_Family_DB(
                                it.bird_family_id, it.bird_family_name, it.bird_family_pic
                            )
                        )


                    }

                    adapter = Bird_Family_Adapter(
                        itemsModalList,
                        requireContext(),
                        this@BirdFamilyFragment
                    )
                    adapter!!.setData(itemsModalList)
                    adapter!!.notifyDataSetChanged()




                    recycler_view!!.adapter = adapter

                }

                override fun onFailure(call: Call<List<Bird_Family_DB>>, t: Throwable) {
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
        callBirdFamilyData()
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        setHasOptionsMenu(true)

//        val qrcode = requireArguments().getString("qrcode")
//        if(qrcode != null){
//            Snackbar.make(
//                requireActivity().findViewById(android.R.id.content),
//                "qrcode",
//                Snackbar.LENGTH_LONG
//            ).show()
//        }

        shimmerFrameLayout = shimmerLayout

        floating_action_button.setOnClickListener {
            val scanner = IntentIntegrator.forSupportFragment(this@BirdFamilyFragment)
            scanner.setPrompt("สแกนไปยังคิวอาร์โค้ด");
            scanner.setDesiredBarcodeFormats(IntentIntegrator.QR_CODE)
            scanner.setBeepEnabled(false)
            scanner.initiateScan()
        }


        recycler_view!!.layoutManager = GridLayoutManager(context, 3)
        recycler_view!!.itemAnimator = DefaultItemAnimator() as RecyclerView.ItemAnimator?

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


    override fun onActivityResult(requestCode: Int, resultCode: Int, data: Intent?) {
        if (resultCode == Activity.RESULT_OK) {
            val result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data)
            if (result != null && result.contents != null) {
                val action =
                    BirdFamilyFragmentDirections.actionBirdFamilyFragmentToScanFragment(result.contents)
                findNavController().navigate(action)
            } else {
                super.onActivityResult(requestCode, resultCode, data)
            }
        }
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_bird_family, container, false)
    }

    override fun ClickedItem(birdFamilyDb: Bird_Family_DB) {

        val action = BirdFamilyFragmentDirections.actionBirdFamilyFragmentToBirdsFragment(
            birdFamilyDb.bird_family_id.toInt(),
            birdFamilyDb.bird_family_name
        )
        findNavController().navigate(action)

    }

}