module AllCategoryFilter
  include Liquid::StandardFilters

  def all_category(posts)
    counts = {}

    posts.each do |post|
      post['category'].each do |category|
        if counts[category]
          counts[category] += 1
        else
          counts[category] = 1
        end
      end
    end

    category = counts.keys
    category.reject { |t| t.empty? }
      .map { |category| { 'name' => category, 'count' => counts[category] } }
      .sort { |category1, category2| category2['count'] <=> category1['count'] }
  end
end

Liquid::Template.register_filter(AllCategoryFilter)
