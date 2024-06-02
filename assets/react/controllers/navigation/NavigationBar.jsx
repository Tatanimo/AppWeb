import React, {useEffect, useState} from "react";
import LoginRegisterModal from "../modals/LoginRegisterModal";
import ProfileDropdown from "../dropdown/ProfileDropdown";
import { EventSourcePolyfill } from "event-source-polyfill";
import { ReactSVG } from 'react-svg';
import HamburgerMenuDropdown from "../dropdown/HamburgerMenuDropdown";

export default function NavigationBar({userSerialize, professionalSerialize, jwtToken, urlMercure}) {
    const notifsStorage = localStorage.getItem("notifications");

    const [openModal, setOpenModal] = useState(false);
    const [notifications, setNotifications] = useState(Array.isArray(JSON.parse(notifsStorage)) ? JSON.parse(notifsStorage).length : 0);

    const user = userSerialize ? JSON.parse(userSerialize) : null;
    const professional = professionalSerialize ? JSON.parse(professionalSerialize) : null;

    useEffect(() => {
        if (user) {
            const url = JSON.parse(urlMercure);
            const jwt = JSON.parse(jwtToken.replace(/\s/g, ''));
    
            const eventSource = new EventSourcePolyfill(url, { 
                withCredentials: true, 
                headers: {
                    'Authorization': `Bearer ${jwt}`
                },
                heartbeatTimeout: 120000,
            });
            
            eventSource.onmessage = event => {
                let notifsArray = JSON.parse(localStorage.getItem("notifications"));
                const uuid = JSON.parse(event.data).uuid.toString();

                if (uuid != window.location.pathname.split("/").pop()) {
                    if (Array.isArray(notifsArray)) {
                        if (!notifsArray.includes(uuid)) {
                            notifsArray.push(uuid);
                        }
                    } else {
                        notifsArray = [JSON.parse(event.data).uuid];
                    }
    
                    localStorage.setItem("notifications", JSON.stringify(notifsArray));
                    window.dispatchEvent(new Event("storage"));
                    setNotifications(notifsArray.length);
                }
            }
        }

        // si on entre dans la chat room qui possède la notif, alors on enlève la notif
        if (Array.isArray(JSON.parse(notifsStorage))) {
            if (JSON.parse(notifsStorage).includes(window.location.pathname.split("/").pop())) {
                const filter = JSON.parse(notifsStorage).filter((e) => e != window.location.pathname.split("/").pop());
                localStorage.setItem("notifications", JSON.stringify(filter));
                setNotifications(filter.length);
            }
        }
    }, []);

    return (
        <>
            <nav>
                <div className="xl:hidden flex items-center pe-8 justify-between">
                    <a href="/">
                        <img src="/img/icons/logo_tatanimo.svg"
                            className="h-24"/>
                    </a>
                    <ul className="flex items-center gap-6">
                        <li className="hover:bg-light-gray p-2 rounded-xl transition [&>*]:p-0 [&>*]:m-0 [&>*]:bg-transparent">
                            <HamburgerMenuDropdown notifications={notifications} />
                        </li>
                        <li className="hover:bg-light-gray p-2 rounded-xl transition [&>*]:p-0 [&>*]:m-0 [&>*]:bg-transparent">
                                {user ? (
                                    <ProfileDropdown user={user} professional={professional} />
                                ) : (
                                    <a id="link-login" className="cursor-pointer"
                                    onClick={() => setOpenModal(true)}>
                                        <img src="/img/icons/login.svg"
                                            className="h-8"/>
                                    </a>
                                )}
                        </li>
                    </ul>
                </div>
                <div className="xl:flex items-center pe-8 justify-between hidden">
                    <a href="/">
                        <img src="/img/icons/logo_tatanimo.svg"
                            className="h-24"/>
                    </a>
                    <ul className="flex items-center gap-12 text-xl font-ChunkFive">
                        <li>
                            <a href="/about"
                            className="hover:underline">QUI SOMMES-NOUS</a>
                        </li>
                        <li>
                            <a href="/services"
                            className="hover:underline">SERVICES</a>
                        </li>
                        <li>
                            <a href="#"
                            className="hover:underline">BLOG</a>
                        </li>
                        <li>
                            <a href="/contact"
                            className="hover:underline">CONTACT</a>
                        </li>
                    </ul>
                    <ul className="flex items-center gap-6">
                        <li className="hover:bg-light-gray p-2 rounded-xl transition">
                            <a href="/messages" className="relative">
                                <img src="/img/icons/mail.svg"
                                    className="h-8"/>
                                {notifications > 0 ? (
                                    <div className="-top-2 -right-2 absolute rounded-full bg-red-300 p-2 flex justify-center items-center min-w-6 max-h-6">
                                        <span className="top-[2px] right-[3px] z-10 absolute rounded-full bg-red-300 p-2 flex justify-center items-center animate-ping w-3/4 h-5/6"></span>
                                        <span className="font-sans">{notifications}</span>
                                    </div>
                                ) : null}
                            </a>
                        </li>
                        <li className="hover:bg-light-gray p-2 rounded-xl transition [&>*]:p-0 [&>*]:m-0 [&>*]:bg-transparent">
                            {user ? (
                                <ProfileDropdown user={user} professional={professional} />
                            ) : (
                                <a id="link-login" className="cursor-pointer"
                                onClick={() => setOpenModal(true)}>
                                    <img src="/img/icons/login.svg"
                                        className="h-8"/>
                                </a>
                            )}
                        </li>
                    </ul>
                </div>
            </nav>
            <LoginRegisterModal openModal={openModal}
                                setOpenModal={setOpenModal}/>
        </>
    );
}