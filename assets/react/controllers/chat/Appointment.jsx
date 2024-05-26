import React, { useState } from "react";
import axios from "axios";
import {endpoint} from "../../../config";

<<<<<<< HEAD
export default function Appointment({contentState, authorId, userId, room, id}) {
    const [appointment, setAppointment] = useState(JSON.parse(contentState));
=======
export default function Appointment({
                                        contentState,
                                        authorId,
                                        userId,
                                        room,
                                        id,
                                        response,
                                        userResponse,
                                        setUserResponse,
                                        setResponse,
                                        setContentState,
                                    }) {
    const appointment = JSON.parse(contentState);
>>>>>>> b8fe254144a0a0480dfe2def2e4f0c296a7c9c04
    const answeredAppointment = async (appointment, answer) => {
        await axios.post("/ajax/appointments", appointment, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then(res => {
                appointment.answered = true;
                appointment.accepted = answer;

                setResponse(answer);
                setUserResponse(true);

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
<<<<<<< HEAD
                d'animaux {appointment.accepted != undefined ? (appointment.accepted ?
                    <div className="main-container">
                        <div className="check-container">
                            <div className="check-background">
                                <svg viewBox="0 0 65 51"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 25L27.3077 44L58.5 7"
                                          stroke="white"
                                          strokeWidth="13"
                                          strokeLinecap="round"
                                          strokeLinejoin="round"/>
                                </svg>
                            </div>
                        </div>
                    </div> : "refusé") : null}</h4>
=======
                d'animaux {appointment.accepted !== undefined ? (response ?
                    <img src={`${endpoint.img}/icons/success.svg`}
                         alt="Succès"
                         className="h-[24px]"/> : <img src={`${endpoint.img}/icons/cancel.svg`}
                                                       alt="Refusé"
                                                       className="h-[24px]"/>) : null}</h4>
>>>>>>> b8fe254144a0a0480dfe2def2e4f0c296a7c9c04
            <br/>
            {appointment.animals.map(animal => {
                return (
                    <div key={animal.id}
                         className="flex justify-between">
                        <p className="font-bold mr-2">Animal:</p>
                        <p>{animal.fk_category.name} ({animal.race}) - {animal.name}</p>
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
            {authorId != userId ? (
                !userResponse ?
                    <div className="flex items-center justify-between mt-3">
                        <button onClick={() => answeredAppointment(appointment, false)}
                                type="button"
                                className="bg-red-600 hover:bg-red-700 transition font-Roboto text-white px-4 py-2 rounded-[12px]">Refuser
                        </button>
                        <button onClick={() => answeredAppointment(appointment, true)}
                                type="button"
                                className="bg-green-600 hover:bg-green-700 transition font-Roboto text-white px-4 py-2 rounded-[12px]">Accepter
                        </button>
                    </div> : null
            ) : null}
        </div>
    );
}