import json
import chardet

def parse_equipment_file(file_path):
    # Nhận diện encoding
    with open(file_path, 'rb') as f:
        raw = f.read()
        encoding = chardet.detect(raw)['encoding']
    
    # Đọc lại bằng encoding đúng
    text = raw.decode(encoding)
    lines = [line for line in text.splitlines()]
    print(len(lines))
    chunk_size = 170
    equipment = []

    for i in range(0, len(lines), chunk_size):
        chunk = lines[i:i + chunk_size]
        if len(chunk) >= 4:
            item_id = chunk[0]
            name = chunk[3]
            equipment.append({'id': item_id, 'name': name})

    return equipment

# Xuất ra JSON
items = parse_equipment_file('items.aeitems')
with open('equipment.json', 'w', encoding='utf-8') as f:
    json.dump(items, f, ensure_ascii=False, indent=2)

print(f"✅ Đã xuất {len(items)} trang bị vào equipment.json")
