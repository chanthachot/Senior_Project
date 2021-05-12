package com.example.finaproject.Fragment

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import androidx.viewpager.widget.ViewPager
import com.example.finaproject.R
import com.example.finaproject.adapter.MyAdapter
import com.google.android.material.tabs.TabLayout
import com.google.android.material.tabs.TabLayout.OnTabSelectedListener
import com.google.android.material.tabs.TabLayout.TabLayoutOnPageChangeListener
import kotlinx.android.synthetic.main.foundbirdpublic.view.*
import kotlinx.android.synthetic.main.fragment_found_bird.*
import kotlinx.android.synthetic.main.fragment_found_bird.view.*


class FoundBirdFragment : Fragment() {


    var tabLayout: TabLayout? = null
    var viewPager: ViewPager? = null

    private val tabIcons = intArrayOf(
        R.drawable.multipleperson_white,
        R.drawable.ic_person_white_2
    )

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)


        floating_action_button_add_foundbird.setOnClickListener {
            var action =
                FoundBirdFragmentDirections.actionFoundBirdFragmentToAddFoundBirdPublic()
            findNavController().navigate(action)
        }


        ViewPager()
    }

    fun ViewPager() {
        tabLayout = requireView().tabLayout
        viewPager = requireView().viewPager


        tabLayout!!.addTab(tabLayout!!.newTab().setText("สาธารณะ"))
        tabLayout!!.addTab(tabLayout!!.newTab().setText("ส่วนตัว"))

        tabLayout!!.getTabAt(0)!!.setIcon(tabIcons[0]);
        tabLayout!!.getTabAt(1)!!.setIcon(tabIcons[1]);

        tabLayout!!.tabGravity = TabLayout.GRAVITY_FILL;


        val adapter = MyAdapter(
            requireContext(),
            childFragmentManager,
            tabLayout!!.tabCount
        )


        viewPager!!.adapter = adapter

        viewPager!!.addOnPageChangeListener(TabLayoutOnPageChangeListener(tabLayout))

        tabLayout!!.addOnTabSelectedListener(object : OnTabSelectedListener {
            override fun onTabSelected(tab: TabLayout.Tab) {
                viewPager!!.currentItem = tab.position
            }

            override fun onTabUnselected(tab: TabLayout.Tab) {
            }

            override fun onTabReselected(tab: TabLayout.Tab) {
            }
        })

    }

    override fun onResume() {
        super.onResume()

    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_found_bird, container, false)
    }
}