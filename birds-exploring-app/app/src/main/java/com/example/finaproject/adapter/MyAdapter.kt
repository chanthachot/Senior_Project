package com.example.finaproject.adapter

import android.content.Context
import androidx.fragment.app.Fragment
import androidx.fragment.app.FragmentManager
import androidx.fragment.app.FragmentPagerAdapter
import com.example.finaproject.Fragment.FoundBirdPrivateFragment
import com.example.finaproject.Fragment.FoundBirdPublicFragment

class MyAdapter(context: Context, fm: FragmentManager?, totalTabs: Int) : FragmentPagerAdapter(fm!!, BEHAVIOR_RESUME_ONLY_CURRENT_FRAGMENT) {

    private val myContext: Context? = context
    private var totalTabs: Int = totalTabs

    override fun getItem(position: Int): Fragment {
        return when (position) {
            0 -> {
                FoundBirdPublicFragment()
            }
            1 -> {
                FoundBirdPrivateFragment()
            }
            else ->
                FoundBirdPublicFragment()
        }
    }

    override fun getCount(): Int {
        return totalTabs
    }

}