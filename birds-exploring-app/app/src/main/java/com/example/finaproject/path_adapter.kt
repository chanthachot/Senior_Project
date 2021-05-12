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
import com.facebook.shimmer.Shimmer
import com.facebook.shimmer.ShimmerDrawable
import kotlinx.android.synthetic.main.route.view.*


class path_adapter(
    val item: List<PathDB>,
    val context: Context,
    var clickListener: ClickListener
) : RecyclerView.Adapter<path_adapter.MyViewHolder>(), Filterable {


    var itemsModalList = ArrayList<PathDB>()
    var itemsModalListFilter = ArrayList<PathDB>()

    fun setData(itemsModalList: ArrayList<PathDB>) {
        this.itemsModalList = itemsModalList
        this.itemsModalListFilter = itemsModalList
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): MyViewHolder {
        val view_item = LayoutInflater.from(parent.context).inflate(R.layout.route, parent, false)
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
        holder.tv_route_name?.text = itemsModal.path_name
        holder.iv_route.load("https://image.freepik.com/free-vector/perspective-3d-city-map-with-pin-pointers-abstarct-gps-navigation-vector-concept_53562-4840.jpg") {
            placeholder(shimmerDrawable)
        }


        holder.itemView.setOnClickListener {
            clickListener.ClickedItem(itemsModal)
        }
    }

    class MyViewHolder(view: View) : RecyclerView.ViewHolder(view) {
        val tv_route_name = view.tv_route_name
        val iv_route = view.iv_route
    }

    interface ClickListener {
        fun ClickedItem(pathDB: PathDB)

    }

    internal var filterListResult: List<PathDB>

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
                    val resultList = ArrayList<PathDB>()
                    for (row in item) {
//                        if(row.bird_name!!.toLowerCase().contains(charSearch.toLowerCase()))
//                            resultList.add(row)
//                        if(row.bird_commonname!!.toLowerCase().contains(charSearch.toLowerCase()))
//                            resultList.add(row)

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
                itemsModalList = filterResults!!.values as ArrayList<PathDB>
                notifyDataSetChanged()
            }

        }
    }

}