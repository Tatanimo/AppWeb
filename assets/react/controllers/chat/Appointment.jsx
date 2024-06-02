import React, { useState } from "react";
import axios from "axios";
import {endpoint} from "../../../config";

export default function Appointment({contentState, authorId, userId, room, id}) {
    const [appointment, setAppointment] = useState(JSON.parse(contentState));

    const answeredAppointment = async (appointment, answer) => {
        await axios.post("/ajax/appointments", appointment, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(res => {
                appointment.answered = true;
                appointment.accepted = answer;

                updateMessage(appointment).then(
                    setAppointment(appointment),
                );
            })
            .catch(err => console.error(err));
    };

    const updateMessage = async (appointment) => {
        await axios.post(`/ajax/messages/update/${id}`, {appointment: appointment}, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(res => addMessageAppointment(appointment))
            .catch(err => console.error(err));
    };

    const addMessageAppointment = async (appointment) => {
        await axios.post(`/ajax/messages/appointment/${room}`, {
            appointment: appointment,
            type: "answered-appointment",
        }, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
    };

    return (
        <div id="appointment-card"
             className="bg-white p-4 w-fit m-6 rounded">
            <h4 className="font-ChunkFive text-2xl flex items-center gap-2">Garde
                d'animaux {appointment.accepted !== undefined ? (appointment.accepted ?
                <img src={`${endpoint.img}/icons/success.svg`}
                        alt="Succès"
                        className="h-[24px]"/> 
                        : 
                <img src={`${endpoint.img}/icons/cancel.svg`}
                    alt="Refusé"
                    className="h-[24px]"/>) : null}
            </h4>
            <br/>
            {appointment.animals.map(animal => {
                return (
                    <div key={animal.id}
                         className="flex justify-between">
                        <p className="font-bold mr-2">Animal:</p>
                        <p>{animal.fk_category.name} {animal.race ? `(${animal.race})` : null} - {animal.name}</p>
                    </div>
                );
            })}
            <div className="flex justify-between">
                <p className="font-bold mr-2">Date de début:</p>
                <p>{new Date(appointment.date[0]).toLocaleDateString()}</p>
            </div>
            <div className="flex justify-between">
                <p className="font-bold mr-2">Date de fin:</p>
                <p>{new Date(appointment.date[1]).toLocaleDateString()}</p>
            </div>
            <div className="flex justify-between">
                <p className="font-bold mr-2">Prix:</p>
                <p>{appointment.price}€</p>
            </div>
            <br/>
            {authorId != userId && !appointment.answered ? (
                <div className="flex items-center justify-between mt-3">
                    <button onClick={() => answeredAppointment(appointment, false)}
                            type="button"
                            className="bg-red-600 hover:bg-red-700 transition font-Roboto text-white px-4 py-2 rounded-[12px]">Refuser
                    </button>
                    <button onClick={() => answeredAppointment(appointment, true)}
                            type="button"
                            className="bg-green-600 hover:bg-green-700 transition font-Roboto text-white px-4 py-2 rounded-[12px]">Accepter
                    </button>
                </div> 
            ) : null}
        </div>
    );
}