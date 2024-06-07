import React from "react";

export default function ThirdHeader({content, color, className}) {
    return (
        <h4 className={`font-ChunkFive uppercase pb-5 xl:text-2xl text-xl ${className}
        ${color === "white" ? "text-white" : ""} 
        ${color === "black" ? "text-black" : ""}`}>
            {content}
        </h4>
    );
}