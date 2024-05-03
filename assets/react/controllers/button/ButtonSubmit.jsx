import React from "react";

export default function ButtonLink({content, className}) {
    return (
        <button onClick className={`inline-block justify-center active:scale-95 hover:bg-blue-purple-hover transition font-ChunkFive text-white text-xl bg-blue-purple px-7 py-5 rounded-xl uppercase ${className}`}>{content}</button>
    );
}