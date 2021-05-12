package com.example.finaproject

import android.app.ProgressDialog
import android.content.Intent
import android.os.Bundle
import android.text.Editable
import android.text.TextWatcher
import android.util.Log
import android.util.Patterns
import android.view.View
import android.widget.Spinner
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import cn.pedant.SweetAlert.SweetAlertDialog
import com.google.firebase.auth.FirebaseAuth
import com.google.firebase.database.DatabaseReference
import com.google.firebase.database.FirebaseDatabase
import kotlinx.android.synthetic.main.activity_login.*
import kotlinx.android.synthetic.main.activity_register.*
import kotlinx.android.synthetic.main.activity_register.email
import kotlinx.android.synthetic.main.activity_register.password
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response


class RegisterActivity : AppCompatActivity() {
    private lateinit var auth: FirebaseAuth

    val userClient = UserAPI.create()


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_register)


        auth = FirebaseAuth.getInstance()

        submit_register.setOnClickListener {

            signUpUser()

        }

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

        password.addTextChangedListener(object : TextWatcher {
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

        confirm_password.addTextChangedListener(object : TextWatcher {
            override fun beforeTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {

            }

            override fun onTextChanged(p0: CharSequence?, p1: Int, p2: Int, p3: Int) {
                if (password.text.toString() != confirm_password.text.toString()) {
                    confirm_password.error = "รหัสผ่านไม่ตรงกัน"
                }
            }

            override fun afterTextChanged(p0: Editable?) {

            }


        })

    }

    private fun signUpUser() {

        if (FirstName.text.toString().isEmpty()) {
            FirstName.error = "กรุณากรอกชื่อ"
            FirstName.requestFocus()
            return
        }

        if (LastName.text.toString().isEmpty()) {
            LastName.error = "กรุณากรอกนามสกุล"
            LastName.requestFocus()
            return
        }

        if (email.text.toString().isEmpty()) {
            email.error = "กรุณากรอกอีเมล"
            email.requestFocus()
            return
        } else {
            if (!Patterns.EMAIL_ADDRESS.matcher(email.text.toString()).matches()) {
                email.error = "กรุณากรอกอีเมลให้ถูกต้อง"
                email.requestFocus()
                return
            }
        }

        if (password.text.toString().isEmpty()) {
            password.error = "กรุณากรอกรหัสผ่าน"
            password.requestFocus()
            return
        } else {
            if (password.text.toString().trim().length < 6) {
                password.error = "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว"
                password.requestFocus()
                return
            }
        }

        if (confirm_password.text.toString().isEmpty()) {
            confirm_password.error = "กรุณายืนยันรหัสผ่าน"
            confirm_password.requestFocus()
            return
        } else {
            if (password.text.toString() != confirm_password.text.toString()) {
                confirm_password.error = "รหัสผ่านไม่ตรงกัน"
                confirm_password.requestFocus()
                return
            }
        }


        val progressDialog = ProgressDialog(this)
        progressDialog.show()
        progressDialog.setContentView(R.layout.loading)
        progressDialog.setCanceledOnTouchOutside(false)
        progressDialog.window!!.setBackgroundDrawableResource(android.R.color.transparent)


        auth.createUserWithEmailAndPassword(email.text.toString(), password.text.toString())
            .addOnCompleteListener(this) { task ->
                if (task.isSuccessful) {
                    progressDialog.dismiss()
                    val user = auth.currentUser


                    user!!.sendEmailVerification()
                        .addOnCompleteListener { task ->
                            if (task.isSuccessful) {
                                val sweet_success =
                                    SweetAlertDialog(this, SweetAlertDialog.SUCCESS_TYPE)
                                sweet_success.setCanceledOnTouchOutside(false)
                                sweet_success.setTitleText("สมัครสมาชิกสำเร็จ")
                                    .setContentText("กรุณายืนยันอีเมล")
                                    .setConfirmText("ตกลง")
                                    .setConfirmClickListener {
                                        startActivity(Intent(this, LoginActivity::class.java))
                                        finish()
                                    }
                                    .show()

                                userClient.register(
                                    user!!.uid,
                                    FirstName.text.toString(),
                                    LastName.text.toString(),
                                    email.text.toString()
                                ).enqueue(object : Callback<UserDB> {
                                    override fun onResponse(call: Call<UserDB>, response: Response<UserDB>) {

                                    }

                                    override fun onFailure(call: Call<UserDB>, t: Throwable) {

                                    }

                                })
                            }
                        }

                } else {
                    progressDialog.dismiss()
                    val sweet_error = SweetAlertDialog(this, SweetAlertDialog.ERROR_TYPE)
                    sweet_error.setCanceledOnTouchOutside(false)
                    sweet_error.setTitleText("มีอีเมลนี้อยู่ในระบบแล้ว")
                        .setContentText("กรุณาลองใหม่อีกครั้ง")
                        .setConfirmText("ตกลง")
                        .setConfirmClickListener {
                            FirstName.clearFocus()
                            LastName.clearFocus()
                            email.clearFocus()
                            password.clearFocus()
                            confirm_password.clearFocus()
                            FirstName.text.clear()
                            LastName.text.clear()
                            email.text.clear()
                            password.text.clear()
                            confirm_password.text.clear()
                            FirstName.setError(null)
                            LastName.setError(null)
                            email.setError(null)
                            password.setError(null)
                            confirm_password.setError(null)
                            it.dismissWithAnimation()
                        }
                        .show()
                }
            }
    }


    fun btn_back_register(v: View) {
        finish()
    }
}
