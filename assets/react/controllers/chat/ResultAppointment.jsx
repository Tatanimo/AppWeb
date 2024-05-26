import React from "react";

export default function ResultAppointment({response}) {
    return (
        <div id="appointment-card"
             className="bg-white p-4 w-fit m-6 rounded">
            <span>
                Votre proposition a été {response ? "accepté" : "refusé"} !
            </span>
        </div>
    );
}