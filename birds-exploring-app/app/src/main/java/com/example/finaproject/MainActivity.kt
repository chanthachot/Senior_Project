package com.example.finaproject

import android.app.Activity
import android.content.Context
import android.content.Intent
import android.net.ConnectivityManager
import android.net.NetworkInfo
import android.os.Bundle
import android.view.Menu
import android.view.MenuItem
import androidx.appcompat.app.ActionBarDrawerToggle
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import androidx.core.view.isVisible
import androidx.navigation.findNavController
import androidx.navigation.fragment.findNavController
import androidx.navigation.ui.AppBarConfiguration
import androidx.navigation.ui.navigateUp
import androidx.navigation.ui.setupActionBarWithNavController
import androidx.navigation.ui.setupWithNavController
import cn.pedant.SweetAlert.SweetAlertDialog
import com.example.finaproject.Fragment.BirdFamilyFragment
import com.example.finaproject.Fragment.BirdFamilyFragmentDirections
import com.example.finaproject.Fragment.FoundBirdFragmentDirections
import com.example.finaproject.Fragment.ScanFragment
import com.google.firebase.auth.FirebaseAuth
import com.google.zxing.integration.android.IntentIntegrator
import kotlinx.android.synthetic.main.activity_main.*
import kotlinx.android.synthetic.main.content_main.*
import kotlinx.android.synthetic.main.nav_header.view.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response

class MainActivity : AppCompatActivity() {

    private lateinit var auth: FirebaseAuth
    val userClient = UserAPI.create()

    lateinit var toggle: ActionBarDrawerToggle
    private lateinit var appBarConfiguration: AppBarConfiguration

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser

        toggle = ActionBarDrawerToggle(this, drawerLayout, R.string.open, R.string.open)
        drawerLayout.addDrawerListener(toggle)
        toggle.syncState()

        val toolbar: Toolbar = findViewById(R.id.toolbar)
        setSupportActionBar(toolbar)


        val navController = findNavController(R.id.nav_host_fragment)
        appBarConfiguration = AppBarConfiguration(
            setOf(
                R.id.birdFamilyFragment,
                R.id.exploreFragment,
                R.id.foundBirdFragment,
                R.id.birdsFragment,
                R.id.birdDetailFragment,
                R.id.foundBirdPublicFragment,
                R.id.foundBirdPrivateFragment,
                R.id.fbpublic_detail_fragment,
                R.id.addFoundBirdPublic,
                R.id.subAddFoundBirdPublic,
                R.id.selectMapInFoundBirdPublic,
                R.id.saveDetailFoundBirdPublic,
                R.id.routeFragment,
                R.id.fbprivate_detail_fragment,
                R.id.showRouteMap,
                R.id.scanFragment
            ), drawerLayout
        )
        setupActionBarWithNavController(navController, appBarConfiguration)

        bottom_nav_view.setOnNavigationItemSelectedListener {
            when (it.itemId) {
                R.id.nav_home -> {
                    findNavController(R.id.nav_host_fragment)
                        .navigate(R.id.birdFamilyFragment)
                }
                R.id.nav_explore -> {
                    findNavController(R.id.nav_host_fragment)
                        .navigate(R.id.exploreFragment)
                }
                R.id.nav_route -> {
                    findNavController(R.id.nav_host_fragment)
                        .navigate(R.id.routeFragment)
                }
                R.id.nav_found_bird -> {
                    if (user != null && user.isEmailVerified) {
                        findNavController(R.id.nav_host_fragment)
                            .navigate(R.id.foundBirdFragment)
                    } else {
                        val intent = Intent(applicationContext, LoginActivity::class.java)
                        startActivity(intent)
                        finish()
                    }
                }
            }
            true
        }


        nav_view.setupWithNavController(navController)

        nav_view.setNavigationItemSelectedListener {
            when (it.itemId) {
                R.id.nav_logout -> {
                    val sweet_warning = SweetAlertDialog(this, SweetAlertDialog.WARNING_TYPE)
                    sweet_warning.setCanceledOnTouchOutside(false)
                    sweet_warning.setContentText("คุณแน่ใจหรือไม่ว่าต้องการออกจากระบบ")
                        .setCancelText("ไม่")
                        .setCancelClickListener(SweetAlertDialog.OnSweetClickListener {
                            it.dismissWithAnimation()
                        })
                        .setConfirmText("ใช่")
                        .setConfirmClickListener(SweetAlertDialog.OnSweetClickListener {
                            auth.signOut()
                            startActivity(Intent(this, LoginActivity::class.java))
                        })
                        .show()
                }
            }
            true
        }


        val menu: Menu = nav_view.getMenu()
        for (menuItemIndex in 0 until menu.size()) {
            val menuItem: MenuItem = menu.getItem(menuItemIndex)
            val userImageNavHeader = nav_view.getHeaderView(0).userImageNavHeader
            if (menuItem.getItemId() === R.id.nav_logout) {

                if (user != null && user.isEmailVerified) {
                    menuItem.isVisible = true
                    userImageNavHeader.isVisible = true


                } else {
                    menuItem.isVisible = false
                    userImageNavHeader.isVisible = false


                }
            }

        }


        if (user != null && user.isEmailVerified) {

            userClient.retrieve_user_id(user.uid).enqueue(object : Callback<List<UserDB>> {
                override fun onResponse(
                    call: Call<List<UserDB>>,
                    response: Response<List<UserDB>>
                ) {
                    response.body()?.forEach {

                        val userEmailNavHeader = nav_view.getHeaderView(0).userEmailNavHeader
                        val userNameNavHeader = nav_view.getHeaderView(0).userNameNavHeader
                        val userLastNameNavHeader = nav_view.getHeaderView(0).userLastNameNavHeader
                        userEmailNavHeader.text = it.email
                        userNameNavHeader.text = it.first_name
                        userLastNameNavHeader.text = it.last_name
                    }

                }

                override fun onFailure(call: Call<List<UserDB>>, t: Throwable) =
                    t.printStackTrace()
            })


        }

    }


    override fun onResume() {
        noInternet()
        super.onResume()
    }

    fun noInternet() {
        val connectionManager: ConnectivityManager =
            this.getSystemService(Context.CONNECTIVITY_SERVICE) as ConnectivityManager
        val activeNetwork: NetworkInfo? = connectionManager.activeNetworkInfo
        val isConnect: Boolean = activeNetwork?.isConnectedOrConnecting == true

        if (!isConnect) {
            intent = Intent(this, NoInternet::class.java)
            startActivity(intent)
            finish()
        }
    }


    override fun onOptionsItemSelected(item: MenuItem): Boolean {
        if (toggle.onOptionsItemSelected(item)) {
            return true
        }
        return super.onOptionsItemSelected(item)
    }

    override fun onSupportNavigateUp(): Boolean {
        val navController = findNavController(R.id.nav_host_fragment)
        return navController.navigateUp(appBarConfiguration) || super.onSupportNavigateUp()
    }


}
