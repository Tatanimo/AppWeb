import React from "react";

export default function Button({content, className}) {
    return (
        <a href="#"
           className={`hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase ${className}`}>{content}</a>
    );
}