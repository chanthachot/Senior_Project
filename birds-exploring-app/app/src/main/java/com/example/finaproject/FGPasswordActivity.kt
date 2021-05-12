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
import cn.pedant.SweetAlert.SweetAlertDialog
import com.google.android.material.snackbar.Snackbar
import com.google.firebase.auth.FirebaseAuth
import kotlinx.android.synthetic.main.activity_fgpassword.*
import kotlinx.android.synthetic.main.activity_login.*
import kotlinx.android.synthetic.main.activity_register.*
import kotlinx.android.synthetic.main.activity_register.email
import java.lang.Exception

class FGPasswordActivity : AppCompatActivity() {
    private lateinit var auth: FirebaseAuth

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_fgpassword)


        auth = FirebaseAuth.getInstance()


        email.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

            }

            override fun onTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {
                if (!Patterns.EMAIL_ADDRESS.matcher(email.text.toString()).matches()) {
                    email.error = "กรุณากรอกอีเมลให้ถูกต้อง"
                }
            }

            override fun afterTextChanged(p0: Editable?) {

            }


        })

    }
    fun submit_forgot(v: View){
            doForgot()
    }

    private fun doForgot(){
        if (email.text.toString().isEmpty()) {
            email.error = "กรุณากรอกอีเมล"
            email.requestFocus()
            return
        }else{
            if (!Patterns.EMAIL_ADDRESS.matcher(email.text.toString()).matches()) {
                email.error = "กรุณากรอกอีเมลให้ถูกต้อง"
                email.requestFocus()
                return
            }
        }

        val progressDialog = ProgressDialog(this)
        progressDialog.show()
        progressDialog.setContentView(R.layout.loading)
        progressDialog.setCanceledOnTouchOutside(false)
        progressDialog.window!!.setBackgroundDrawableResource(android.R.color.transparent)


        auth.sendPasswordResetEmail(email.text.toString())
            .addOnCompleteListener(this) { task ->
                if (task.isSuccessful) {
//                    Toast.makeText(baseContext, auth.currentUser!!.isEmailVerified.toString(), Toast.LENGTH_SHORT).show()
//                    if(auth.currentUser!!.isEmailVerified) {
                        progressDialog.dismiss()
                        val sweet_success = SweetAlertDialog(this, SweetAlertDialog.SUCCESS_TYPE)
                        sweet_success.setCanceledOnTouchOutside(false)
                        sweet_success.setTitleText("ส่งอีเมลรีเซ็ตรหัสผ่านสำเร็จ")
                            .setContentText("กรุณาตรวจสอบอีเมล")
                            .setConfirmText("ตกลง")
                            .setConfirmClickListener {
                                startActivity(Intent(this, LoginActivity::class.java))
                            }
                            .show()
//                    }else{
//                        progressDialog.dismiss()
//                        email.text.clear()
//                        email.setError(null)
//                        email.clearFocus()
//                        Toast.makeText(
//                            baseContext, "อีเมลนี้ยังไม่ได้ยืนยัน",
//                            Toast.LENGTH_SHORT
//                        ).show()
//                    }
                }else{
                    progressDialog.dismiss()
                    email.text.clear()
                    email.setError(null)
                    email.clearFocus()
                    Snackbar.make(
                        findViewById(android.R.id.content), "ไม่มีอีเมลนี้ในระบบ",
                        Snackbar.LENGTH_LONG
                    ).show()
                }
            }

    }


    fun btn_back_forgotpw(v: View){
       finish()
    }

}
