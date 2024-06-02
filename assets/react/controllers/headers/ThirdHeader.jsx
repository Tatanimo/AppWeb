import React from "react";

export default function ThirdHeader({content, color, className}) {
    return (
        <h3 className={`font-ChunkFive uppercase pb-5 xl:text-4xl text-2xl ${className}
        ${color === "white" ? "text-white" : ""} 
        ${color === "black" ? "text-black" : ""}`}>
            {content}
        </h3>
    );
}