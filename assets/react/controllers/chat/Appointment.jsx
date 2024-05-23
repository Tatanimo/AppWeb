import React from "react";
import axios from "axios";

export default function Appointment({contentState, authorId, userId, room, id}) {
    const appointment = JSON.parse(contentState);
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
                    setContentState(JSON.stringify(appointment)),
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
             className="bg-white p-4 w-fit m-6">
            <h4 className="font-bold text-xl">Rendez-vous {appointment.accepted != undefined ? (appointment.accepted ? "accepté" : "refusé") : null}</h4>
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
                <p className="font-bold mr-2">Date de rendez-vous:</p>
                <p>{new Date(appointment.date[0]).toLocaleDateString()} - {new Date(appointment.date[1]).toLocaleDateString()}</p>
            </div>
            <div className="flex justify-between">
                <p className="font-bold mr-2">Prix:</p>
                <p>{appointment.price}€</p>
            </div>
            <br/>
            {authorId != userId && !appointment.answered ? (
                <div className="flex justify-end mt-3">
                    <button onClick={() => answeredAppointment(appointment, false)}
                            type="button"
                            className="mr-2">Refuser
                    </button>
                    <button onClick={() => answeredAppointment(appointment, true)}
                            type="button">Accepter
                    </button>
                </div>
            ) : null}
        </div>
    );
}