import React from "react";

export default function NavigationBar() {
    return (
        <nav className="flex items-center justify-between pe-8">
            <a href="/">
                <img src="/svg/logo_tatanimo.svg"
                     className="h-24"/>
            </a>
            <ul className="flex items-center gap-12 text-xl font-ChunkFive">
                <li>
                    <a href="#">QUI SOMMES-NOUS</a>
                </li>
                <li>
                    <a href="#">SERVICES</a>
                </li>
                <li>
                    <a href="#">BLOG</a>
                </li>
                <li>
                    <a href="#">CONTACT</a>
                </li>
            </ul>
            <ul className="flex items-center gap-6">
                <li>
                    <a href="#">
                        <img src="/svg/mail.svg"
                             className="h-8"/>
                    </a>
                </li>
                <li>
                    <a href="/register">
                        <img src="/svg/user_profile.svg"
                             className="h-8"/>
                    </a>
                </li>
            </ul>
        </nav>
    );
}