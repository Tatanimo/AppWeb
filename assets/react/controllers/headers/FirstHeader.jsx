import React from "react";

export default function FirstHeader({content, color, fontSize, className}) {
    return (
        <h1 className={`font-ChunkFive uppercase pb-5 ${fontSize} ${className}
        ${color === "white" ? "text-white" : ""} 
        ${color === "black" ? "text-black" : ""}`}>
            {content}
        </h1>
    );
}