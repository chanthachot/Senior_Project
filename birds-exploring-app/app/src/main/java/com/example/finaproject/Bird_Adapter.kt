package com.example.finaproject

import android.content.Context
import android.graphics.Color
import android.util.Log
import android.view.LayoutInflater
import android.view.View

import android.view.ViewGroup
import android.widget.Filter
import android.widget.Filterable
import androidx.recyclerview.widget.RecyclerView
import coil.api.load
import com.bumptech.glide.Glide
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import kotlinx.android.synthetic.main.bird.view.*
import kotlinx.android.synthetic.main.bird_family.view.*
import kotlinx.android.synthetic.main.bird_family.view.tv_bird_family_name
import kotlinx.android.synthetic.main.fragment_fbprivate_detail.*


class Bird_Adapter(
    val item: List<BirdsDB>,
    val context: Context,
    var clickListener: ClickListener
) : RecyclerView.Adapter<Bird_Adapter.MyViewHolder>(), Filterable {


    var itemsModalList = ArrayList<BirdsDB>()
    var itemsModalListFilter = ArrayList<BirdsDB>()


    fun setData(itemsModalList: ArrayList<BirdsDB>) {
        this.itemsModalList = itemsModalList
        this.itemsModalListFilter = itemsModalList
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): MyViewHolder {
        val view_item = LayoutInflater.from(parent.context).inflate(R.layout.bird, parent, false)
        return MyViewHolder(view_item)

    }


    override fun getItemCount(): Int {
        return itemsModalList.size
    }

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {

        val shimmer = Shimmer.ColorHighlightBuilder().setBaseColor(Color.parseColor("#F3F3F3"))
            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7")).setHighlightAlpha(1F).setDropoff(
                50F
            ).build()
        val shimmerDrawable = ShimmerDrawable()
        shimmerDrawable.setShimmer(shimmer)

        val itemsModal = itemsModalList[position]
        holder.tv_bird_name?.text = itemsModal.bird_name
        holder.tv_common_name?.text = itemsModal.bird_commonname
        holder.iv_bird.load("http://" + ServerIP().server_ip + "/birds-exploring-backend/backend/birddb/dist/birds_img/" + itemsModal.bird_pic_name) {
            placeholder(shimmerDrawable)
            crossfade(true)
        }

        holder.itemView.setOnClickListener {
            clickListener.ClickedItem(itemsModal)
        }

    }

    class MyViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tv_bird_name = view.tv_bird_name
        val tv_common_name = view.tv_common_name
        val iv_bird = view.iv_bird
    }

    interface ClickListener {
        fun ClickedItem(birdsDB: BirdsDB)

    }

    internal var filterListResult: List<BirdsDB>

    init {
        this.filterListResult = item
    }

    override fun getFilter(): Filter {
        return object : Filter() {
            override fun performFiltering(charsequence: CharSequence?): FilterResults {

                val charSearch = charsequence.toString()
                if (charSearch.isEmpty())
                    filterListResult = item
                else {
                    val resultList = ArrayList<BirdsDB>()
                    for (row in item) {
                        if (row.bird_name!!.toLowerCase().contains(charSearch.toLowerCase()))
                            resultList.add(row)
                        if (row.bird_commonname!!.toLowerCase().contains(charSearch.toLowerCase()))
                            resultList.add(row)

                    }
                    filterListResult = resultList
                }
                val filterResults = Filter.FilterResults()
                filterResults.values = filterListResult
                return filterResults
            }

            override fun publishResults(
                charSequence: CharSequence?,
                filterResults: FilterResults?
            ) {
                itemsModalList = filterResults!!.values as ArrayList<BirdsDB>
                notifyDataSetChanged()
            }

        }
    }

}