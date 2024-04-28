import AirDatepicker from 'air-datepicker'
import 'air-datepicker/air-datepicker.css'
import React from "react";
    
export default function DatePicker() {
    new AirDatepicker('#date', {
        inline: true
    })
    
    return (
        <input placeholder="Date de début"
               name="date"
               id="date"/>
    )
}