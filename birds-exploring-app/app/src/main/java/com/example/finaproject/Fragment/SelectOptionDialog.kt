package com.example.finaproject.Fragment

import android.graphics.Color
import android.graphics.drawable.ColorDrawable
import android.os.Bundle
import android.util.Log
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.RadioButton
import androidx.fragment.app.DialogFragment
import com.example.finaproject.R
import com.google.android.material.bottomsheet.BottomSheetDialogFragment
import com.google.android.material.snackbar.Snackbar
import kotlinx.android.synthetic.main.fragment_select_option_dialog.*
import kotlinx.android.synthetic.main.fragment_select_option_dialog.view.*
import kotlinx.android.synthetic.main.fragment_select_option_dialog.view.btnCancel
import kotlinx.android.synthetic.main.fragment_select_option_dialog.view.btnSave
import kotlinx.android.synthetic.main.savemap_dialog.view.*

class SelectOptionDialog : DialogFragment() {

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)


    }

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        // Inflate the layout for this fragment
        val rootView = inflater.inflate(R.layout.fragment_select_option_dialog, container, false)

        dialog!!.window!!.setBackgroundDrawable(ColorDrawable(Color.TRANSPARENT))

        rootView.btnSave.setOnClickListener {

            val selectID = SelectSave.checkedRadioButtonId
            val radio = rootView.findViewById<RadioButton>(selectID)


            if (radio != null) {
                var result = radio.text.toString()
                if (result == "สาธารณะ") {
                    result = 1.toString()
                } else if (result == "ส่วนตัว") {
                    result = 2.toString()
                } else {
                    result = 3.toString()
                }

                val i = requireActivity().intent
                i.putExtra("select_save", result)
                targetFragment!!.onActivityResult(targetRequestCode, 101, i)
                dismiss()

            } else {
                Snackbar.make(rootView, "กรุณาเลือกอย่างใดอย่างหนึ่ง", Snackbar.LENGTH_LONG).show()
            }


        }

        rootView.btnCancel.setOnClickListener {
            dismiss()
        }
        return rootView

    }

}