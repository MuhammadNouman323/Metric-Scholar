# Scholar Metric — Project Documentation

Generated project analysis artifacts for thesis, SRS submission, and MS Project scheduling.

## Files

| File | Description |
|------|-------------|
| [SRS-Scholar-Metric.md](./SRS-Scholar-Metric.md) | Formal Software Requirements Specification (PDF-ready) |
| [scholar-metric-work-plan.csv](./scholar-metric-work-plan.csv) | MS Project import schedule (12-week WBS) |
| [diagrams/](./diagrams/) | PlantUML source files for all diagrams |

## MS Project Import

1. Open Microsoft Project → **File → Open**
2. Select `scholar-metric-work-plan.csv`
3. Map columns: ID, Name, Outline Level, Duration, Predecessors, Resource Names
4. Set project start date under **Project → Project Information**
5. Switch to **Gantt Chart** view

## Render PlantUML Diagrams

Install [PlantUML](https://plantuml.com/) (requires Java), then:

```bash
cd docs/diagrams
plantuml *.puml
```

Output PNG/SVG files are created alongside each `.puml` file.

Alternatively, paste `.puml` contents into the [PlantUML online server](https://www.plantuml.com/plantuml/uml/).

## Diagram Index

- `use-case-diagram.puml` — Use case diagram
- `erd.puml` — Entity Relationship Diagram
- `architecture-diagram.puml` — C4 container architecture
- `sequence-publish-evaluation.puml` — Admin publishes evaluation
- `sequence-submit-feedback.puml` — Student submits anonymous feedback
- `sequence-evaluation-lifecycle.puml` — Automated lifecycle processing
- `class-diagram.puml` — Domain and application class diagram

## Export SRS to PDF

Using Pandoc:

```bash
pandoc docs/SRS-Scholar-Metric.md -o docs/SRS-Scholar-Metric.pdf --toc
```

Or open `SRS-Scholar-Metric.md` in VS Code / Typora and export to PDF.
