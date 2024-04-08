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
                        <li>
                            <ThirdHeader content="Social"
                                         color="white"
                                         className=""/>
                        </li>
                        <li>
                            <Paragraph content="Instagram"
                                       color="white"
                                       className=""/>
                        </li>
                        <li>
                            <Paragraph content="Linkedin"
                                       color="white"
                                       className=""/>
                        </li>
                        <li>
                            <Paragraph content="Facebook"
                                       color="white"
                                       className=""/>
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
                            <Paragraph content="Mentions légales"
                                       color="white"
                                       className=""/>
                        </li>
                        <li>
                            <Paragraph content="Qui sommes-nous ?"
                                       color="white"
                                       className=""/>
                        </li>
                        <li>
                            <Paragraph content="Services"
                                       color="white"
                                       className=""/>
                        </li>
                        <li>
                            <Paragraph content="Contact"
                                       color="white"
                                       className=""/>
                        </li>
                    </ul>
                </div>
            </div>
        </>
    );
}