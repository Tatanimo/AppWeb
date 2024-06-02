import React from "react";

import ThirdHeader from "../headers/ThirdHeader";
import Paragraph from "../paragraph/Paragraph";
import {endpoint} from "../../../config";

export default function Footer() {
    return (
        <>
            <div className="flex lg:flex-row flex-col w-full">
                <div className="w-1/2 flex items-start justify-center">
                    <a href="/"
                       className="w-1/2">
                        <img src={`${endpoint.img}/icons/logo_tatanimo.svg`}
                             alt="logo"
                             className="w-full"/>
                    </a>
                </div>
                <div className="w-1/2 flex items-center justify-center flex-col lg:flex-row">
                    <div className="w-1/2">
                        <ul className="flex flex-col gap-6">
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
                    <div className="w-1/2">
                        <ul className="flex flex-col gap-6">
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