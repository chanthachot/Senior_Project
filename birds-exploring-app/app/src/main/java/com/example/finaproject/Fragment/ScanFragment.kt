package com.example.finaproject.Fragment

import android.app.ProgressDialog
import android.content.Intent
import android.os.Bundle
import android.os.Handler
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.navigation.fragment.navArgs
import androidx.recyclerview.widget.DefaultItemAnimator
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.finaproject.*
import com.facebook.shimmer.ShimmerFrameLayout
import com.google.android.gms.maps.model.LatLng
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_scan.*
import kotlinx.coroutines.delay
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class ScanFragment : Fragment(),
    scan_adapter.ClickListener {

    private var shimmerFrameLayout: ShimmerFrameLayout? = null

    val scanClient = BirdAPI.create()
    var adapter: scan_adapter? = null
    val itemsModalList = ArrayList<BirdsDB>()

    var array_bird_id = ArrayList<String>()

    val args: ScanFragmentArgs by navArgs()

    private fun callQRCode() {


        shimmerFrameLayout!!.startShimmer();

        val qrcode = args.qrcode
        var separate = qrcode!!.split("/".toRegex())

        for (i in 0..separate.size - 2) {
            var i = i
            if (i % 3 == 0) {
                val bird_id = separate[i + 2]
                Log.e("bird_id",bird_id)
                array_bird_id.add(bird_id)

                Handler().postDelayed({
                    scanClient.retrieve_birds(array_bird_id)
                        .enqueue(object : Callback<List<BirdsDB>> {
                            override fun onResponse(
                                call: Call<List<BirdsDB>>,
                                response: Response<List<BirdsDB>>
                            ) {

                                shimmerFrameLayout!!.stopShimmer()
                                shimmerFrameLayout!!.visibility = View.GONE;

                                itemsModalList.clear();
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


                                adapter = scan_adapter(
                                    itemsModalList, requireContext(), this@ScanFragment
                                )
                                adapter!!.setData(itemsModalList)
                                adapter!!.notifyDataSetChanged()
                                recycler_view_scan!!.adapter = adapter
                            }

                            override fun onFailure(call: Call<List<BirdsDB>>, t: Throwable) {
                                Snackbar.make(
                                    requireActivity().findViewById(android.R.id.content),
                                    "ไม่สามารถโหลดข้อมูลได้ กรุณาลองใหม่อีกครั้ง",
                                    Snackbar.LENGTH_LONG
                                ).show()
                            }
                        })

                }, 500)

            }
        }

    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        shimmerFrameLayout = shimmerLayoutScan

        ShowScanMap.setOnClickListener {
            val intent = Intent(requireContext(), ShowScannedMap::class.java)
            intent.putExtra("qrcode", args.qrcode)
            startActivity(intent)
        }

        recycler_view_scan!!.layoutManager =
            LinearLayoutManager(requireContext(), LinearLayoutManager.VERTICAL, false)
        recycler_view_scan!!.itemAnimator =
            DefaultItemAnimator() as RecyclerView.ItemAnimator?
    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment

        return inflater.inflate(R.layout.fragment_scan, container, false)
    }

    override fun onResume() {
        super.onResume()
        callQRCode()
    }

    override fun ClickedItem(birdsDB: BirdsDB) {

        val action = ScanFragmentDirections.actionScanFragmentToBirdDetailFragment(birdsDB.bird_id)
        findNavController().navigate(action)

    }

}