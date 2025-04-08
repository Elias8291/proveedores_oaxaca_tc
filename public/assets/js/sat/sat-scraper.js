import { createModal } from "./utils.js";

export async function scrapeSATData(qrUrl) {
    try {
        const response = await fetch(qrUrl, {
            headers: {
                Accept: "text/html",
                "User-Agent":
                    "Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0.4472.124 Safari/537.36",
            },
        });
        if (!response.ok)
            throw new Error(`Error: ${response.status} ${response.statusText}`);
        const doc = new DOMParser().parseFromString(
            await response.text(),
            "text/html"
        );
        const extractedData = [];
        let email = "",
            razonSocial = "",
            nombre = "",
            apellidoPaterno = "",
            apellidoMaterno = "",
            rfc = "";

        doc.querySelectorAll(".ui-li.ui-li-static.ui-body-c").forEach((el) => {
            const rfcMatch = el.textContent.match(/RFC:\s*([A-Z0-9]+)/i);
            if (rfcMatch && rfcMatch[1]) rfc = rfcMatch[1];
        });

        if (!rfc) {
            for (const item of doc.querySelectorAll("li")) {
                const rfcMatch = item.textContent.match(/RFC:\s*([A-Z0-9]+)/i);
                if (rfcMatch && rfcMatch[1]) {
                    rfc = rfcMatch[1];
                    break;
                }
            }
        }

        if (!rfc) {
            const directMatch = (await response.text()).match(
                /RFC:\s*([A-Z0-9]+)/i
            );
            if (directMatch && directMatch[1]) rfc = directMatch[1];
        }

        doc.querySelectorAll('[data-role="listview"]').forEach(
            (section, index) => {
                const title =
                    section
                        .querySelector('[data-role="list-divider"]')
                        ?.textContent.trim() || `Sección ${index + 1}`;
                if (!title || !section.querySelector("table")) return;
                const sectionData = {
                    sectionNumber: index + 1,
                    sectionName: title,
                    fields: [],
                };
                section.querySelectorAll("tr[data-ri]").forEach((row) => {
                    const [labelCell, valueCell] = row.querySelectorAll(
                        'td[role="gridcell"]'
                    );
                    if (labelCell && valueCell) {
                        const label = labelCell.textContent
                            .replace(/:/g, "")
                            .trim();
                        const value = valueCell.textContent.trim();
                        if (
                            label &&
                            value &&
                            !value.includes("$(function") &&
                            !sectionData.fields.some((f) => f.label === label)
                        ) {
                            if (/correo|email/i.test(label)) email = value;
                            if (/denominación|razón social/i.test(label))
                                razonSocial = value;
                            if (label.toLowerCase() === "nombre") nombre = value;
                            if (/apellido paterno/i.test(label))
                                apellidoPaterno = value;
                            if (/apellido materno/i.test(label))
                                apellidoMaterno = value;
                            if (/rfc/i.test(label)) rfc = value;
                            sectionData.fields.push({ label, value });
                        }
                    }
                });
                if (sectionData.fields.length) extractedData.push(sectionData);
            }
        );

        const nombreCompleto = [nombre, apellidoPaterno, apellidoMaterno]
            .filter((part) => part && part.trim())
            .join(" ");
        return { extractedData, email, razonSocial, nombreCompleto, rfc };
    } catch (error) {
        throw new Error(
            `No se pudo obtener la información del SAT: ${error.message}`
        );
    }
}

export function showSATDataModal(satData, qrUrl) {
    createModal({
        className: "modal-overlay sat-modal",
        html: `<div class="modal-container"><div class="modal-header"><h3>Información del SAT</h3><div class="header-actions"><button class="icon-btn link-btn" onclick="window.open('${qrUrl}', '_blank')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg></button><button class="icon-btn close-modal">×</button></div></div><div class="modal-body">${
            satData.rfc
                ? `<div class="rfc-display"><strong>RFC:</strong> ${satData.rfc} (${
                      satData.rfc.length === 12 ? "Persona Moral" : satData.rfc.length === 13 ? "Persona Física" : "Longitud inválida"
                  })</div>`
                : ""
        }${
            satData.extractedData.length === 0
                ? "<p>No se encontraron datos en la página del SAT.</p>"
                : satData.extractedData
                      .map(
                          (s) =>
                              `<div class="sat-section"><h4>${
                                  s.sectionName
                              }</h4><div class="table-responsive"><table><tbody>${s.fields
                                  .map(
                                      (f) =>
                                          `<tr><th>${f.label}</th><td>${f.value}</td></tr>`
                                  )
                                  .join("")}</tbody></table></div></div>`
                      )
                      .join("")
        }</div><div class="modal-footer"><button class="small-btn outline" id="closeModalBtn">Cerrar</button></div></div>`,
    });
}

document.head.appendChild(
    Object.assign(document.createElement("style"), {
        textContent: `.email-display{padding:10px;margin:10px 0;background:#f5f5f5;border-radius:4px}.name-display{padding:10px;margin:10px 0;background:#f5f5f5;border-radius:4px}.rfc-display{padding:10px;margin:10px 0;background:#f8f8f8;border-radius:4px;font-size:16px;border-left:4px solid #2196F3}`,
    })
);