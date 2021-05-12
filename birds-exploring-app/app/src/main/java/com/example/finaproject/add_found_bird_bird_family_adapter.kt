package com.example.finaproject

import android.content.Context
import android.graphics.Color
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
import kotlinx.android.synthetic.main.addbird_public_birdfamily_item.view.*


class add_found_bird_bird_family_adapter(
    val item: List<Bird_Family_DB>,
    val context: Context,
    var clickListener: ClickListener
) : RecyclerView.Adapter<add_found_bird_bird_family_adapter.MyViewHolder>(), Filterable {

    var itemsModalList = ArrayList<Bird_Family_DB>()
    var itemsModalListFilter = ArrayList<Bird_Family_DB>()

    fun setData(itemsModalList: ArrayList<Bird_Family_DB>) {
        this.itemsModalList = itemsModalList
        this.itemsModalListFilter = itemsModalList
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): MyViewHolder {
        val view_item = LayoutInflater.from(parent.context)
            .inflate(R.layout.addbird_public_birdfamily_item, parent, false)
        return MyViewHolder(view_item)

    }


    override fun getItemCount(): Int {
        return itemsModalList.size
    }

    override fun onBindViewHolder(holder: MyViewHolder, position: Int) {

        val shimmer = Shimmer.ColorHighlightBuilder().setBaseColor(Color.parseColor("#F3F3F3"))
            .setBaseAlpha(1F).setHighlightColor(Color.parseColor("#E7E7E7")).setHighlightAlpha(1F)
            .setDropoff(
                50F
            ).build()
        val shimmerDrawable = ShimmerDrawable()
        shimmerDrawable.setShimmer(shimmer)


        val itemsModal = itemsModalList[position]
        holder.tv_bird_family_name?.text = itemsModal.bird_family_name
        holder.iv_birdFamily.load("http://" + ServerIP().server_ip + "/birds-exploring/backend/birddb/dist/bird_family_img/" + itemsModal.bird_family_pic) {
            placeholder(shimmerDrawable)
            crossfade(true)
        }

        holder.itemView.setOnClickListener {
            clickListener.ClickedItem(itemsModal)

        }
    }

    class MyViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val tv_bird_family_name = itemView.tv_bird_family_name
        val iv_birdFamily = itemView.iv_bird_foundbird_public
    }


    interface ClickListener {
        fun ClickedItem(birdFamilyDb: Bird_Family_DB)

    }

    internal var filterListResult: List<Bird_Family_DB>

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
                    val resultList = ArrayList<Bird_Family_DB>()
                    for (row in item) {
                        if (row.bird_family_name!!.toLowerCase().contains(charSearch.toLowerCase()))
                            resultList.add(row)
                    }
                    filterListResult = resultList
                }
                val filterResults = Filter.FilterResults()
                filterResults.values = filterListResult
                return filterResults
            }

            override fun publishResults(p0: CharSequence?, filterResults: FilterResults?) {
                itemsModalList = filterResults!!.values as ArrayList<Bird_Family_DB>
                notifyDataSetChanged()

            }

        }
    }
//
}