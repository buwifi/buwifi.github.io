Jekyll::Hooks.register :posts, :post_write do |post|
  all_existing_category = Dir.entries("_category")
    .map { |t| t.match(/(.*).md/) }
    .compact.map { |m| m[1] }

  category = post['category'].reject { |t| t.empty? }
  category.each do |category|
    generate_category_file(category) if !all_existing_category.include?(category)
  end
end

def generate_category_file(category)
  File.open("_category/#{category}.md", "wb") do |file|
#    file << "---\ncategory-name: #{category}\n---\n"
    file << "---\nlayout: category\ncategory-name: #{category}\n---\n"
  end
end
