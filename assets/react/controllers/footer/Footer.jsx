import React from "react";
import ThirdHeader from "../headers/ThirdHeader";
import Paragraph from "../paragraph/Paragraph";

export default function Footer() {
    return (
        <>
            <div className="w-1/2 flex items-start justify-center">
                <img src="img/icons/logo_tatanimo.svg"
                     className="w-1/2"
                     alt="logo"/>
            </div>
            <div className="w-1/2 flex">
                <div className="w-1/2">
                    <ul className="flex flex-col gap-6">
                        <li href="#">
                            <ThirdHeader content="Social"
                                         color="white"
                                         className=""/>
                        </li>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Instagram"
                                       color="white"
                                       className=""/>
                        </a>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Linkedin"
                                       color="white"
                                       className=""/>
                        </a>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Facebook"
                                       color="white"
                                       className=""/>
                        </a>
                    </ul>
                </div>
                <div className="w-1/2">
                    <ul className="flex flex-col gap-6">
                        <li>
                            <ThirdHeader content="Mentions"
                                         color="white"
                                         className=""/>
                        </li>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Mentions légales"
                                       color="white"
                                       className=""/>
                        </a>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Qui sommes-nous ?"
                                       color="white"
                                       className=""/>
                        </a>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Services"
                                       color="white"
                                       className=""/>
                        </a>
                        <a href="#"
                           className="hover:underline text-white">
                            <Paragraph content="Contact"
                                       color="white"
                                       className=""/>
                        </a>
                    </ul>
                </div>
            </div>
        </>
    );
}