import React, {useState} from "react";
import LoginRegisterModal from "../modals/LoginRegisterModal";

export default function NavigationBar({user}) {
    const [openModal, setOpenModal] = useState(false);
    const [userInfo, setUserInfo] = useState(JSON.parse(user) ?? null);
    return (
        <>
            <nav className="flex items-center justify-between pe-8">
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
                        <a href="#">
                            <img src="/img/icons/mail.svg"
                                 className="h-8"/>
                        </a>
                    </li>
                    <li className="hover:bg-light-gray p-2 rounded-xl transition">
                        {userInfo ? (
                            <a className="cursor-pointer"
                            href={`/profil/${userInfo.id}`}>
                                <img src="/img/icons/user_profile.svg"
                                    className="h-8"/>
                            </a>
                        ) : (
                            <a className="cursor-pointer"
                            onClick={() => setOpenModal(true)}>
                                <img src="/img/icons/login.svg"
                                    className="h-8"/>
                            </a>
                        )}
                    </li>
                </ul>
            </nav>
            <LoginRegisterModal openModal={openModal}
                                setOpenModal={setOpenModal} setUserInfo={setUserInfo}/>
        </>
    );
}