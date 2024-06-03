import React from "react";

import ThirdHeader from "../headers/ThirdHeader";
import Paragraph from "../paragraph/Paragraph";
import {endpoint} from "../../../config";

export default function Footer() {
    return (
        <>
            <div className="flex lg:flex-row flex-col w-full">
                <div className="lg:w-1/2 w-full flex items-start justify-center mb-8 lg:mb-0">
                    <a href="/"
                       className="lg:w-1/2 w-full">
                        <img src={`${endpoint.img}/icons/logo_tatanimo.svg`}
                             alt="logo"
                             className="w-full"/>
                    </a>
                </div>
                <div className="lg:w-1/2 w-full flex items-start justify-center flex-col lg:flex-row px-4 lg:px-0">
                    <div className="lg:w-1/2 w-full mb-8 lg:mb-0">
                        <ul className="flex flex-col lg:gap-6 gap-4">
                            <li>
                                <ThirdHeader content="Social"
                                             color="white"
                                             className=""/>
                            </li>
                            <li>
                                <a href="#"
                                   className="hover:underline text-white">
                                    <Paragraph content="Instagram"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   className="hover:underline text-white">
                                    <Paragraph content="Linkedin"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   className="hover:underline text-white">
                                    <Paragraph content="Facebook"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="lg:w-1/2 w-full">
                        <ul className="flex flex-col lg:gap-6 gap-4">
                            <li>
                                <ThirdHeader content="Mentions"
                                             color="white"
                                             className=""/>
                            </li>
                            <li>
                                <a href="#"
                                   className="hover:underline text-white">
                                    <Paragraph content="Mentions légales"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                            <li>
                                <a href="/about"
                                   className="hover:underline text-white">
                                    <Paragraph content="Qui sommes-nous ?"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   className="hover:underline text-white">
                                    <Paragraph content="Services"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                            <li>
                                <a href="/contact"
                                   className="hover:underline text-white">
                                    <Paragraph content="Contact"
                                               color="white"
                                               className=""/>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </>
    );
}