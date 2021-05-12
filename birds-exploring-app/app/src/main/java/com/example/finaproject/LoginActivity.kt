package com.example.finaproject

import android.app.ProgressDialog
import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.util.Patterns
import android.view.View
import android.widget.Toast
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.database.DatabaseReference
import com.google.firebase.database.FirebaseDatabase
import kotlinx.android.synthetic.main.activity_login.email
import kotlinx.android.synthetic.main.activity_login.password


class LoginActivity : AppCompatActivity() {
    private lateinit var auth: FirebaseAuth
    private lateinit var refUsers: DatabaseReference

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)


        auth = FirebaseAuth.getInstance()
        val user = auth.currentUser



        email.addTextChangedListener(object: TextWatcher {
            override fun beforeTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

            }

            override fun onTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {
                if(!Patterns.EMAIL_ADDRESS.matcher(email.text.toString()).matches()) {
                    email.error = "กรุณากรอกอีเมลให้ถูกต้อง"
                }
            }

            override fun afterTextChanged(p0: Editable?) {

            }


        })

        password.addTextChangedListener(object: TextWatcher {
            override fun beforeTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

            }

            override fun onTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {
                if (password.text.toString().trim().length < 6) {
                    password.error = "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว"
                }
            }

            override fun afterTextChanged(p0: Editable?) {

            }


        })


    }

    fun btnLogin(v: View){

        doLoggin()
    }

    private fun doLoggin(){
        if (email.text.toString().isEmpty()) {
            email.error = "กรุณากรอกอีเมล"
            email.requestFocus()
            return
        }else{
            if(!Patterns.EMAIL_ADDRESS.matcher(email.text.toString()).matches()) {
                email.error = "กรุณากรอกอีเมลให้ถูกต้อง"
                email.requestFocus()
                return
            }
        }


        if (password.text.toString().isEmpty()) {
            password.error = "กรุณากรอกรหัสผ่าน"
            password.requestFocus()
            return
        }else{
            if (password.text.toString().trim().length < 6) {
                password.error = "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว"
                password.requestFocus()
                return
            }
        }


        val progressDialog = ProgressDialog(this)
        progressDialog.show()
        progressDialog.setContentView(R.layout.loading)
        progressDialog.setCanceledOnTouchOutside(false)
        progressDialog.window!!.setBackgroundDrawableResource(android.R.color.transparent)


        auth.signInWithEmailAndPassword(email.text.toString(), password.text.toString())
            .addOnCompleteListener(this) { task ->
                if (task.isSuccessful) {
                    if(auth.currentUser!!.isEmailVerified){
                        progressDialog.dismiss()
                        startActivity(Intent(this, MainActivity::class.java))
                        finish()
                    }else {
                        progressDialog.dismiss()
                        email.clearFocus()
                        password.clearFocus()
                        email.text.clear()
                        password.text.clear()
                        email.error = null
                        password.error = null
                        Snackbar.make(
                            findViewById(android.R.id.content), "กรุณายืนยันอีเมลก่อนเข้าใช้งาน",
                            Snackbar.LENGTH_LONG
                        ).show()
                    }
                } else {
                    progressDialog.dismiss()
                    email.clearFocus()
                    password.clearFocus()
                    password.text.clear()
                    email.error = null
                    password.error = null
                    Snackbar.make(findViewById(android.R.id.content), "อีเมลหรือรหัสผ่านไม่ถูกต้อง",
                        Snackbar.LENGTH_LONG).show()
                }


            }

    }


    fun btn_back_login(v: View){
        intent = Intent(this@LoginActivity,MainActivity::class.java)
        startActivity(intent)
        finish()
    }

    fun gotoRegister(v: View){
        intent = Intent(this@LoginActivity,RegisterActivity::class.java)
        startActivity(intent)

    }

    fun forgotPassword(v: View){
        intent = Intent(this@LoginActivity,FGPasswordActivity::class.java)
        startActivity(intent)
    }

    override fun onBackPressed() {
        intent = Intent(this@LoginActivity,MainActivity::class.java)
        startActivity(intent)
        finish()
        super.onBackPressed()
    }


}
