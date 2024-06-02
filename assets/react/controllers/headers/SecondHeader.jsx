import React from "react";

export default function SecondHeader({content, color, className}) {
    return (
        <h3 className={`font-ChunkFive uppercase pb-5 xl:text-6xl text-4xl ${className}
        ${color === "white" ? "text-white" : ""} 
        ${color === "black" ? "text-black" : ""}`}>
            {content}
        </h3>
    );
}