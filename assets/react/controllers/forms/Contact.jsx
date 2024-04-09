import React from "react";
import ButtonSubmit from "../button/ButtonSubmit";

export default function Contact() {
    return (
        <form className="w-full flex flex-col gap-6 items-center">
            <div className="flex gap-8 w-full">
                <div className="flex flex-col w-full">
                    <label htmlFor="lastname">Nom</label>
                    <input type="text"
                           id="lastname"
                           name="lastname"
                           placeholder="Votre nom"
                           className="border-2 border-transparent focus:border-blue-purple focus:ring-0"/>
                </div>
                <div className="flex flex-col w-full">
                    <label htmlFor="firstname">Prénom</label>
                    <input type="text"
                           id="firstname"
                           name="firstname"
                           placeholder="Votre prénom"
                           className="border-2 border-transparent focus:border-blue-purple focus:ring-0"/>
                </div>
            </div>
            <div className="flex flex-col w-full">
                <label htmlFor="email">E-mail</label>
                <input type="email"
                       id="email"
                       name="email"
                       placeholder="Votre e-mail"
                       className="border-2 border-transparent focus:border-blue-purple focus:ring-0"/>
            </div>
            <div className="flex flex-col w-full">
                <label htmlFor="message">Message</label>
                <textarea id="message"
                          name="message"
                          placeholder="Votre message"
                          rows="12"
                          className="border-2 border-transparent focus:border-blue-purple focus:ring-0"></textarea>
            </div>
            <ButtonSubmit content="Envoyer"
                          className="my-4"/>
        </form>
    );
}